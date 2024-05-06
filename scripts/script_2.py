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
        import pandas as pd
        import numpy as np
        import tensorflow as tf
        from sklearn.preprocessing import LabelEncoder, MinMaxScaler, OneHotEncoder, OrdinalEncoder
        from sklearn.model_selection import train_test_split
        from keras.models import load_model
        from sklearn.metrics import r2_score
        import os

        tf.keras.utils.disable_interactive_logging()

        # data = {
        #     'loss': 0.6931,
        #     'accuracy': 0.5,
        # }
        # sys.stdout.write(json.dumps(data))
        # sys.stdout.flush()
        # sys.exit(0)
        # # Define the model
        # model = tf.keras.Sequential([
        #     tf.keras.layers.Dense(1, input_shape=(2,), activation='sigmoid')
        # ])

        # # Compile the model
        # model.compile(optimizer='adam',
        #             loss='binary_crossentropy',
        #             metrics=['accuracy'])

        # # Create dummy data
        # X = np.array([[0, 0], [0, 1], [1, 0], [1, 1]])  # Convert to numpy array
        # y = np.array([[0], [1], [1], [0]])  # Convert to numpy array

        # # Train the model
        # model.fit(X, y, epochs=1, verbose=None)

        # # Evaluate the model
        # loss, accuracy = model.evaluate(X, y)
        
        # data = {
        #     'loss': loss,
        #     'accuracy': accuracy
        # }
        
        modelPath = data['model']
        datasetPath = data['dataset']
        

        
        # Load the dataset .npz
        dataset = np.load(datasetPath)
        # X_train = dataset['X_train']
        X_test = dataset['X_test']
        # y_train = dataset['y_train']
        y_test = dataset['y_test']
        
        # Load the model
        model = load_model(modelPath)
        
        model.compile(loss='mean_squared_error',optimizer='adam', metrics=['mse'])
        
        # Load models
        y_pred = model.predict(X_test)
        r2 = r2_score(y_test, y_pred)
        loss, accuracy = model.evaluate(X_test, y_test)
        # print(f"R^2 Score for {model}: {r2:.4f}")
        
        
        
        
        
        data = {
            'loss': loss,
            'accuracy': accuracy,
            'r2': r2
        }
        sys.stdout.write(json.dumps(data))
        sys.stdout.flush()
        sys.exit(0)


except Exception as e:
    print(f'Error: {e}')
    sys.exit(1)

