<head>
    <style>
        .btn-primary {
            width: 40%;
            padding: 10px;
            background-color: #000;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<header>
    <h1>Welcome to Model Appreciator</h1>
    <hr>
    <p>This website allows you to train and test machine learning models conveniently.</p>
</header>
<main>
    <section>
        <h2>What is Model Appreciator?</h2>
        <p>Model Appreciator is a platform where you can train machine learning models by running code or Docker containers on your computer. You can then send the results back to the server for testing and deployment. Whether you're a beginner or an expert, Model Appreciator provides the tools you need to develop and deploy machine learning models efficiently.</p>
    </section>
    <section>
    <?php if (!session()->get('loggedUserId')): ?>
            <h2>Get Started</h2>
            <p>You can check models and use them on the Models section.</p>
            <p>For training your models, simply sign in or register for an account.</p>
            <div class="gap-2">
                <a href="<?= base_url('/auth'); ?>" class="btn btn-primary">Login</a>
                <a href="<?= base_url('/auth/register'); ?>" class="btn btn-success">Register</a>
            </div>
        <?php endif; ?>
    </section>
</main>
