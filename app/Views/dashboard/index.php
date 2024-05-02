
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h1><?= $title; ?></h1>
                <h2 class="mt-3">Welcome, <?= $name; ?></h2>
                <div class="mt-4">
                    <a href="<?= base_url('dashboard/profile'); ?>" class="btn btn-primary me-3">Profile</a>
                    <a href="<?= base_url('auth/logout'); ?>" class="btn btn-danger">Logout</a>
                    <div class="mt-4">
                        <a href="<?= base_url('content'); ?>" class="btn btn-primary">Add Content</a>
                    </div>
                </div>
            </div>
        </div>

