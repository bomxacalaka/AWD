import sys
import json


TEST = False
# TEST = True

try:
    
    if TEST:
        loss = 0.1
        accuracy = 0.9
        
        data = {
            'loss': loss,
            'accuracy': accuracy
        }
        
        sys.stdout.write(json.dumps(data))
        sys.stdout.flush()
        sys.exit(0)
    else:
        
        
        
        import numpy as np
        import tensorflow as tf

        tf.keras.utils.disable_interactive_logging()

        # Define the model
        model = tf.keras.Sequential([
            tf.keras.layers.Dense(1, input_shape=(2,), activation='sigmoid')
        ])

        # Compile the model
        model.compile(optimizer='adam',
                    loss='binary_crossentropy',
                    metrics=['accuracy'])

        # Create dummy data
        X = np.array([[0, 0], [0, 1], [1, 0], [1, 1]])  # Convert to numpy array
        y = np.array([[0], [1], [1], [0]])  # Convert to numpy array

        # Train the model
        model.fit(X, y, epochs=1, verbose=None)

        # Evaluate the model
        loss, accuracy = model.evaluate(X, y)
        
        data = {
            'loss': loss,
            'accuracy': accuracy
        }
        
        
        # print(f'Loss: {loss}, Accuracy: {accuracy}')
        
        sys.stdout.write(json.dumps(data))
        sys.stdout.flush()
        sys.exit(0)


except Exception as e:
    print(f'Error: {e}')
    sys.exit(1)

