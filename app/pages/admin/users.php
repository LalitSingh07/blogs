<?php if($action == 'add'):?>
    <div class="col-md-6 mx-auto">
        <form method="post"> 
        <h1 class="h3 mb-3 fw-normal">Add users</h1>
        <?php if(!empty($errors)):?>
        <div class="alert alert-danger">please fix error</div>
        <?php endif;?>

        <div class="form-floating">
        <input value="<?= oldvalue('username') ?>" name="username" type="text" class="form-control mb-2" id="username" placeholder="Username">
        <label for="fusername">Username</label>
        </div>
        <?php if(!empty($errors['username'])): ?>
        <div class="text-danger"><?=$errors['username']?></div>
        <?php endif;?>

        <div class="form-floating">
        <input value="<?= oldvalue('email') ?>"  name = "email" type="email" class="form-control mb-2" id="email" placeholder="name@example.com">
        <label for="email">Email address</label>
        </div>
        <?php if(!empty($errors['email'])): ?>
        <div class="text-danger"><?=$errors['email']?></div>
        <?php endif;?>
        <div class="form-floating">
        <input value="<?= oldvalue('password') ?>"  name= "password" type="password" class="form-control mb-2" id="Password" placeholder="Password">
        <label for="Password">Password</label>
        </div>
        <?php if(!empty($errors['password'])): ?>
        <div class="text-danger"><?=$errors['password']?></div>
        <?php endif;?>

        <div class="form-floating">
        <input value="<?= oldvalue('retype-password') ?>"  name= "retype-password" type="password" class="form-control" id="CPassword" placeholder="Confirm Password">
        <label for="CPassword">Confirm Password</label>
        </div>
        <?php if(!empty($errors['retype-password'])): ?>
        <div class="text-danger"><?=$errors['retype-password']?></div>
        <?php endif;?>

        <?php if(!empty($errors['remember'])): ?>
        <div class="text-danger mb-2"><?=$errors['remember']?></div>
        <?php endif;?>
        <a href="<?=ROOT?>/admin/users">
        <button class="btn btn-primary mt-2 py-2" type="button">back</button>
        </a>
        <button class="btn btn-primary mt-2 py-2" type="submit">Add User</button>
      
    </form>
  </div> 
  <!-- ---------------edit section---------- -->
<?php elseif($action == 'edit'):?>
    <div class="col-md-6 mx-auto">
        <form method="post" enctype="multipart/form-data"> 
        <h1 class="h3 mb-3 fw-normal">Edit account</h1>

        <?php if(!empty($row)):?>
        <?php if(!empty($errors)):?>
         <div class="alert alert-danger">Please fix the errors below</div>
        <?php endif;?>

        <div class="my-2">
		    	<label class="d-block">
		    		<img class="mx-auto d-block image-preview-edit" src="<?=getimage('')?>" style="cursor: pointer;width: 150px;height: 150px;object-fit: cover;">
		    		<input onchange="display_image_edit(this.files[0])" type="file" name="image" class="d-none">
		    	</label>
		    	<?php if(!empty($errors['image'])):?>
			      <div class="text-danger"><?=$errors['image']?></div>
			    <?php endif;?>

		    	<script>
		    		
		    		function display_image_edit(file)
		    		{
		    			document.querySelector(".image-preview-edit").src = URL.createObjectURL(file);
		    		}
		    	</script>
		    </div>

        <div class="form-floating">
        <input value="<?= oldvalue('username',$row['username']) ?>" name="username" type="text" class="form-control mb-2" id="username" placeholder="Username">
        <label for="fusername">Username</label>
        </div>
        <?php if(!empty($errors['username'])): ?>
        <div class="text-danger"><?=$errors['username']?></div>
        <?php endif;?>

        <div class="form-floating">
        <input value="<?= oldvalue('email',$row['email']) ?>"  name = "email" type="email" class="form-control mb-2" id="email" placeholder="name@example.com">
        <label for="email">Email address</label>
        </div>
        <?php if(!empty($errors['email'])): ?>
        <div class="text-danger"><?=$errors['email']?></div>
        <?php endif;?>
        <div class="form-floating">
        <input value="<?= oldvalue('password') ?>"  name= "password" type="password" class="form-control mb-2" id="Password" placeholder="Password">
        <label for="Password">Password</label>
        </div>
        <?php if(!empty($errors['password'])): ?>
        <div class="text-danger"><?=$errors['password']?></div>
        <?php endif;?>

        <div class="form-floating">
        <input value="<?= oldvalue('retype-password') ?>"  name= "retype-password" type="password" class="form-control" id="CPassword" placeholder="Confirm Password">
        <label for="CPassword">Confirm Password</label>
        </div>
        <?php if(!empty($errors['retype-password'])): ?>
        <div class="text-danger"><?=$errors['retype-password']?></div>
        <?php endif;?>

        <?php if(!empty($errors['remember'])): ?>
        <div class="text-danger mb-2"><?=$errors['remember']?></div>
        <?php endif;?>
        <a href="<?=ROOT?>/admin/users">
        <button class="btn btn-primary mt-2 py-2" type="button">back</button>
        </a>

        <button class="btn btn-primary mt-2 py-2" type="submit">edit account</button>
        <?php else:?>
        <div class="alert alert-danger text-center">Record not found</div>
        <?php endif;?>
    </form>
  </div> 
     
<?php elseif($action == 'delete'):?>
    <div class="col-md-6 mx-auto">
        <form method="post"> 
        <h1 class="h3 mb-3 fw-normal">Delete account</h1>
        <?php if(!empty($row)):?>
        <?php if(!empty($errors)):?>
        <div class="alert alert-danger">please fix error</div>
        <?php endif;?>

        <div class="form-floating">
        <div class="form-control"><?= oldvalue('username',$row['username']) ?></div>
        <label for="fusername">Username</label>
        </div>
        <?php if(!empty($errors['username'])): ?>
        <div class="text-danger"><?=$errors['username']?></div>
        <?php endif;?>

        <div class="form-floating">
        <div class="form-control"><?= oldvalue('email',$row['email']) ?></div>
        <label>Email address</label>
        </div>
        <?php if(!empty($errors['email'])): ?>
        <div class="text-danger"><?=$errors['email']?></div>
        <?php endif;?>
  
        <a href="<?=ROOT?>/admin/users">
        <button class="btn btn-primary mt-2 py-2" type="button">back</button>
        </a>

        <button class="btn btn-danger mt-2 py-2" type="submit">Delete account</button>
        <?php else:?>
        <div class="alert alert-danger text-center">Record not found</div>
        <?php endif;?>
    </form>
  </div> 
<?php else:?> 

    <h4>Users <a href="<?=ROOT?>/admin/users/add"><button class="btn btn-primary">Add New</button></h4></a>
    <div class="table-responsive">

    <table class="table">
        <tr>
            <th>#</th><th>username</th><th>Email</th><th>Role</th><th>image</th>
            <th>Date</th>
            <th>Action</th>
        </tr>

        <?php
        $limit = 10;
        $offset = ($PAGE['pagenumber']-1)*$limit;
        $query = "select * from users order by id desc limit $limit offset $offset";
        $rows = query($query);
        ?>

        <?php if(!empty($rows)):?>
        <?php foreach($rows as $row):?>
        <tr>
            <td><?=$row['id']?></td>
            <td><?=esc($row['username'])?></td>
            <td><?=$row['email']?></td>
            <td><?=$row['role']?></td>
            <td>
                <img src="<?=getimage($row['image'])?>" alt="image"style="width:100px; heigth=100px; object-fit:cover;" >
            </td>
            <td><?=date("jS ,M,Y",strtotime($row['date']))?></td>
            <td> 
            <a href="<?=ROOT?>/admin/users/edit/<?=$row['id']?> ">
                <button class="btn btn-warning text-white btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg></button>
            </a>
            <a href="<?=ROOT?>/admin/users/delete/<?=$row['id']?> ">
                <button class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg></button>
        </a>
            </td>
        </tr>

        <?php endforeach;?>
        <?php endif;?>
    </table>  
    <div class="col-md-12">
        <a href="<?=$PAGE['firstlink']?>">
        <button class="btn btn-primary">first page</button></a>
        <a href="<?=$PAGE['prevlink']?>">
        <button class="btn btn-primary">prev page</button>
        </a>
        <a href="<?=$PAGE['nextlink']?>">
        <button class="btn btn-primary">nextpage</button>
        </a>
    </div> 
    </div>
<?php endif;?> 