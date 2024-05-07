# import json
# with open("/var/www/html/AWD/writable/uploads/0/default_config.json", "w") as f:
#     json.dump({"test":1,"dataset":"test1","model":"test2"}, f)

# import json
# with open("/var/www/html/AWD/writable/uploads/0/default_config.json", 'r') as file:
#     data = json.load(file)
#     print(data)

import sys
import json
import argparse

# parser = argparse.ArgumentParser(description='Script 2')
# parser.add_argument('--file', type=str, help='Path to JSON file')
# parser.add_argument('--var1', type=str, help='Variable')
# parser.add_argument('--var2', type=str, help='Variable')

# args = parser.parse_args()

# with open(args.var2, 'r') as file:
#     data = json.load(file)

# sys.stdout.write(json.dumps([1, 2, vars(args), data]))
# sys.stdout.flush()
# sys.exit(0)
        
# TEST = False
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
        data = {
            'loss': 0.69,
            'accuracy': 0.450,
        }
        sys.stdout.write(json.dumps(data))
        sys.stdout.flush()
        sys.exit(0)
    else:
        import os
        import numpy as np
        from PIL import Image
        import numpy as np
        import tensorflow as tf
        from tensorflow import keras
        from tensorflow.keras import layers

        tf.keras.utils.disable_interactive_logging()

        size = 64  # Specify the target size for resizing and padding
        target_size = (size, size)  # Specify the target size for resizing and padding
        try:
            img_path = data['dataset']  # Specify the path to the image
            print(img_path)
        except:
            img_path = data['img_path']

        print(data['model'])
        print(data['class_names_path'])

        model_path = "/home/jd/saved_model.pb"

        model = tf.keras.models.load_model("/home/jd/model_0.h5")

        with open(data['class_names_path'], "r") as file:
            class_names = [line.strip() for line in file]

        def resize_and_pad_image(img, target_size):
            # Resize the image while maintaining the aspect ratio
            img.thumbnail(target_size, Image.Resampling.LANCZOS)

            # Create a new image with the target size and paste the resized image onto it
            new_img = Image.new("RGB", target_size)
            position = ((target_size[0] - img.size[0]) // 2, (target_size[1] - img.size[1]) // 2)
            new_img.paste(img, position)

            return new_img

        predictions = model.predict(np.array([np.array(resize_and_pad_image(Image.open(img_path), target_size))]))
        max_ = 0
        c = 0
        for i in predictions[0]:
            if i > max_:
                max_ = i
                fc = c
            c += 1
            
        data = {
            'pred': class_names[fc]
        }
        sys.stdout.write(json.dumps(data))
        sys.stdout.flush()
        sys.exit(0)


except Exception as e:
    print(f'Error: {e}')
    sys.exit(1)

