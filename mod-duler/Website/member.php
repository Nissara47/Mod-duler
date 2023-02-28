<?php
session_start();
include("dbconnect.php");
$UserID = $_SESSION['UserID'];
$ProjectID = $_GET['key'];
// query part
$ref = $database->getReference('Project/' . $ProjectID);
$ProjectInfo = $ref->getValue();
$managerInfo = $database->getReference('User/' . $ProjectInfo['ProjectManager'])->getValue();
$i = 1;
$hasMember = $ref->getChild('Member')->getValue();
?>
<html>

<head>
    <title>member</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="./CSS/sidebar.css" rel="stylesheet">
    <style>
        .table{
            width: 75% !important;
        }
    </style>
</head>

<body>
    <!-- navbar -->
    <?php include('Element/navbar.php') ?>

    <!-- main content -->
    <div class="main">
        <!-- sidebar -->
        <?php include('Element/sidebar.php') ?>

        <!-- member section -->
        <div class="col-md-12 content" style="max-width: 80%;">
            <div class="card-body">
                <div class="card-body">
                    <h1 class="display-6"><?php echo $ProjectInfo['ProjectName']; ?>
                    <!-- invite button part. Show when this user is projectmanager. -->
                        <?php if ($UserID == $ProjectInfo['ProjectManager']) { ?>
                        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#member">
                            + invite member
                        </button>
                        <?php } ?>
                    </h1>
                    <!-- invite member Modal -->
                    <div class="modal fade" id="member" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">invite member</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form name="inviteform" method="post" action="member_action.php?key=<?= $ProjectID ?>">
                                        <div class="mb-3">
                                            <label class="form-label">Username</label>
                                            <input name="Username" type="text" class="form-control" id="Username">
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary" name="invite">Invite</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <table class="table table-borderless">
                        <thead class="table-dark">
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row"><?php echo $i; ?></th>
                                <td><?php echo $managerInfo['Name']; ?></td>
                                <td><?php echo $managerInfo['Email']; ?>
                                </td>
                                <td>Project Manager</td>
                            </tr><br>
                            <?php
                            if ($hasMember != false) {
                                // query member part if has member
                                $Member = $ref->getChild('Member')->getValue();
                                foreach ($Member as $key => $member) {
                                    $i++;
                            ?>
                                    <tr>
                                        <th scope="row"><?php echo $i; ?></th>
                                        <td><?php echo $member['Name']; ?></td>
                                        <td><?php echo $member['Email']; ?></td>
                                        <td>Member</td>
                                        <td>
                                            <!-- Delete button part Show when this user is projectmanager. -->
                                            <?php if ($UserID == $ProjectInfo['ProjectManager']) { ?>
                                                <form name="Deleteform" method="post" action="member_action.php?key=<?= $ProjectID ?>">
                                                    <button type="submit" onclick="return confirm('Are you sure?')" name="delete" value='<?= $key ?>' class="btn btn-danger">Delete</button>
                                                </form>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>

</html>