<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome, <?php echo Yii::$app->user->identity->username ?></h1>

        <p class="lead">This is the backend Content Management System (CMS) for The Center of Excellence for Bioinformatics Research site.</p>

        <p></p>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-4">
                <h2>Projects</h2>

                <p>The 'Projects' page is where as an admin you can view, create, update, and delete projects.
                  When creating a project it automatically adds the project folder and project group on Owncloud,
                that way it is ready to go. The same applies when deleteing a project,
                it automatically cleans up everything on the Owncloud side as well. To get started just press the 'Projects' button or tab at the top.</p>

                <p><a class="btn btn-primary" href=" <?php echo Yii::getAlias('@web') . '/index.php/projects/' ?> ">Projects &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Requests</h2>

                <p>The 'Requests' page is where an admin can see the requests of users for a specific project.
                  Here an admin can approve or deny a user to that requested project.
                  Once approved they are (if not already on Owncloud) created on Owncloud and then added to the project group that way they can see the shareed files within the group.
              To get started just press the 'Requests' button below or the tab at the top. </p>

                <p><a class="btn btn-primary" href=" <?php echo Yii::getAlias('@web') . '/index.php/requests/' ?> ">Requests &raquo;</a></p>
            </div>
            <div class="col-lg-4">
                <h2>Users</h2>

                <p>The 'Users' page is where an admin can view any user currently registered with 'The Center of Excellence for Bioinformatics.'
                  From here an admin can also update or delete user information as well as users themselves.
                  However a user still must register from the frontend to be created, they cannot be created from the backend.
                To get started just press the 'Users' button below or the tab at the top. </p>

                <p><a class="btn btn-primary" href=" <?php echo Yii::getAlias('@web') . '/index.php/user/' ?> ">Users &raquo;</a></p>
            </div>
        </div>

    </div>
</div>
