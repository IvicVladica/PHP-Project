<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            Admin
            <small>Subheading</small>
        </h1>



        <?php

        // // $user = new User();

        // // $user->username = "username2";
        // // $user->password = "password2";
        // // $user->first_name = "John";
        // // $user->last_name = "McConel";

        // $user->create();

        $user = User::find_user_by_id(6);

        $user->first_name = "JohnUpdated";
        $user->last_name = "McConelUpdated";

        $user->update();

        ?>



        <ol class="breadcrumb">
            <li>
                <i class="fa fa-dashboard"></i>  <a href="index.html">Dashboard</a>
            </li>
            <li class="active">
                <i class="fa fa-file"></i> Blank Page
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->