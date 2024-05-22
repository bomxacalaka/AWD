import sys
import json
import argparse

TEST = True

try:
    # main.py --data '{"key": "value"}'
    # Create a parser
    parser = argparse.ArgumentParser(description='Script 2')
    
    # Add arguments
    parser.add_argument('--file', type=str, help='Path to JSON file')
    
    # Parse the arguments
    args = parser.parse_args()
    
    if args.file:
        with open(args.file, 'r') as file:
            data = json.load(file)
    else:
        raise ValueError("No file path provided.")
    
    
    TEST = data['test']
    
    if TEST:
        dataout = {
            'loss': 0.69,
            'accuracy': 0.450,
        }
        sys.stdout.write(json.dumps(dataout))
        sys.stdout.flush()
        sys.exit(0)
    else:
        import cv2
        import typing
        import numpy as np
        import pandas as pd

        from mltu.inferenceModel import OnnxInferenceModel
        from mltu.utils.text_utils import ctc_decoder, get_cer

        class ImageToWordModel(OnnxInferenceModel):
            def __init__(self, *args, **kwargs):
                super().__init__(*args, **kwargs)

            def predict(self, image: np.ndarray):
                image = cv2.resize(image, self.input_shapes[0][1:3][::-1])

                image_pred = np.expand_dims(image, axis=0).astype(np.float32)

                preds = self.model.run(self.output_names, {self.input_names[0]: image_pred})[0]

                text = ctc_decoder(preds, self.metadata["vocab"])[0]

                return text


        model = ImageToWordModel(model_path=data['model'])

        image_path = data['dataset']
        # image = cv2.imread(image_path.replace("\\", "/"), cv2.IMREAD_GRAYSCALE)
        # image = cv2.cvtColor(image, cv2.COLOR_GRAY2BGR)
        
        # Crop around the text area

        # Load image, grayscale, Gaussian blur, adaptive threshold
        image = cv2.imread(image_path)
        gray = cv2.cvtColor(image, cv2.COLOR_BGR2GRAY)
        blur = cv2.GaussianBlur(gray, (5,5), 0)
        thresh = cv2.adaptiveThreshold(blur,255,cv2.ADAPTIVE_THRESH_GAUSSIAN_C, cv2.THRESH_BINARY_INV,11,20)

        # Dilate to combine adjacent text contours
        kernel = cv2.getStructuringElement(cv2.MORPH_RECT, (9,9))
        dilate = cv2.dilate(thresh, kernel, iterations=4)

        # Find contours, highlight text areas, and extract ROIs
        cnts = cv2.findContours(dilate, cv2.RETR_EXTERNAL, cv2.CHAIN_APPROX_SIMPLE)
        cnts = cnts[0] if len(cnts) == 2 else cnts[1]

        ROI_number = 0
        preds = []
        for c in cnts:
            area = cv2.contourArea(c)
            if area > 1000:
                x,y,w,h = cv2.boundingRect(c)
                # cv2.rectangle(image, (x, y), (x + w, y + h), (36,255,12), 3)
                ROI = image[y:y+h, x:x+w]
                ROI_number += 1
                cv2.imwrite('ROI_{}.png'.format(ROI_number), ROI)
                
                # image = cv2.imread('ROI_{}.png'.format(ROI_number))
                preds.append(model.predict(ROI))
        
        if not preds:
            preds = ['No text detected']
            
        prediction_text = " ".join(preds)

        # print(f"Image: {image_path}, Prediction: {prediction_text}")
        import os
        dataout = {
            'prediction': prediction_text,
        }
        sys.stdout.write(json.dumps(dataout))
        sys.stdout.flush()
        sys.exit(0)


except Exception as e:
    dataout = {
        'prediction': str(e)
    }
    sys.stdout.write(json.dumps(dataout))
    sys.stdout.flush()
    sys.exit(0)