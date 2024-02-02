<?php if($action == 'add'):?>
  <?php if($_SESSION['user']['role']=='admin'):?>

<div class="col-md-6 mx-auto">
  <form method="post" enctype="multipart/form-data">

    <h1 class="h3 mb-3 fw-normal">Create category</h1>

    <?php if (!empty($errors)):?>
      <div class="alert alert-danger">Please fix the errors below</div>
    <?php endif;?>

    <div class="form-floating">
      <input value="<?=oldvalue('category')?>" name="category" type="text" class="form-control mb-2" id="floatingInput" placeholder="Category">
      <label for="floatingInput">category</label>
    </div>
      <?php if(!empty($errors['category'])):?>
      <div class="text-danger"><?=$errors['category']?></div>
      <?php endif;?>

    <div class="form-floating my-3">
      <select name="disabled" class="form-select">
        <option value="0">Yes</option>
        <option value="1">No</option>
      </select>
      <label for="floatingInput">Active</label>
    </div>

    <a href="<?=ROOT?>/admin/categories">
      <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
  </a>
    <button class="mt-4 btn btn-lg btn-primary float-end" type="submit">Create</button>
   
  </form>
</div>

<?php else:?> 
       
       <div class="alert alert-danger text-center">sorry you are not an Admin
           
       </div>
       <?php endif;?>
<?php elseif($action == 'edit'):?>
<?php if($_SESSION['user']['role']=='admin'):?>
<div class="col-md-6 mx-auto">
  <form method="post" enctype="multipart/form-data">

    <h1 class="h3 mb-3 fw-normal">Edit category</h1>

    <?php if(!empty($row)):?>

      <?php if (!empty($errors)):?>
        <div class="alert alert-danger">Please fix the errors below</div>
      <?php endif;?>

      <div class="form-floating">
        <input value="<?=oldvalue('category', $row['category'])?>" name="category" type="text" class="form-control mb-2" id="floatingInput" placeholder="Username">
        <label for="floatingInput">Username</label>
      </div>
        <?php if(!empty($errors['category'])):?>
        <div class="text-danger"><?=$errors['category']?></div>
        <?php endif;?>

      <div class="form-floating my-3">
        <select name="disabled" class="form-select">
          <option <?=old_select('disabled','0',$row['disabled'])?> value="0">Yes</option>
          <option <?=old_select('disabled','1',$row['disabled'])?> value="1">No</option>
        </select>
        <label for="floatingInput">Active</label>
      </div>


      <a href="<?=ROOT?>/admin/categories">
        <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
    </a>
      <button class="mt-4 btn btn-lg btn-primary  float-end" type="submit">Save</button>
  <?php else:?>

    <div class="alert alert-danger text-center">Record not found!</div>
  <?php endif;?>

  </form>
</div>
<?php else:?> 
       
       <div class="alert alert-danger text-center">sorry you are not an Admin
           
       </div>
       <?php endif;?>
<?php elseif($action == 'delete'):?>
 <?php if($_SESSION['user']['role']=='admin'):?>

<div class="col-md-6 mx-auto">
  <form method="post">

    <h1 class="h3 mb-3 fw-normal">Delete category</h1>

    <?php if(!empty($row)):?>

      <?php if (!empty($errors)):?>
        <div class="alert alert-danger">Please fix the errors below</div>
      <?php endif;?>

      <div class="form-floating">
        <div class="form-control mb-2" ><?=oldvalue('category', $row['category'])?></div>
      </div>
        <?php if(!empty($errors['category'])):?>
        <div class="text-danger"><?=$errors['category']?></div>
        <?php endif;?>

      <div class="form-floating">
        <div class="form-control mb-2" ><?=oldvalue('slug', $row['slug'])?></div>
      </div>
        <?php if(!empty($errors['slug'])):?>
        <div class="text-danger"><?=$errors['slug']?></div>
        <?php endif;?>


      <a href="<?=ROOT?>/admin/categories">
        <button class="mt-4 btn btn-lg btn-primary" type="button">Back</button>
    </a>
      <button class="mt-4 btn btn-lg btn-danger  float-end" type="submit">Delete</button>
  <?php else:?>

    <div class="alert alert-danger text-center">Record not found!</div>
  <?php endif;?>

  </form>
</div>
<?php else:?> 
       
       <div class="alert alert-danger text-center">sorry you are not an Admin
           
       </div>
       <?php endif;?>
<?php else:?>

<h4>
  Categories 
  <a href="<?=ROOT?>/admin/categories/add">
    <button class="btn btn-primary">Add New</button>
  </a>
</h4>

<div class="table-responsive">
<table class="table">
  
  <tr>
    <th>#</th>
    <th>Category</th>
    <th>Slug</th>
    <th>Active</th>
    <th>Action</th>
  </tr>
  <?php  
    $limit = 10;
    $offset = ($PAGE['pagenumber'] - 1) * $limit;

    $query = "select * from categories order by id desc limit $limit offset $offset";
    $rows = query($query);
  ?>

  <?php if(!empty($rows)):?>
    <?php foreach($rows as $row):?>
    <tr>
      <td><?=$row['id']?></td>
      <td><?=esc($row['category'])?></td>
      <td><?=$row['slug']?></td>
      <td><?=$row['disabled'] ? 'No':'Yes'?></td>
      <td>
        <a href="<?=ROOT?>/admin/categories/edit/<?=$row['id']?>">
        <button class="btn btn-warning text-white btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                </svg></button>
        </a>
        <a href="<?=ROOT?>/admin/categories/delete/<?=$row['id']?>">
        <button class="btn btn-danger btn-sm"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg></button>
        </a>
      </td>
    </tr>
    <?php endforeach;?>
  <?php endif;?>
</table>

<div class="col-md-12 mb-4">
  <a href="<?=$PAGE['firstlink']?>">
    <button class="btn btn-primary">First Page</button>
  </a>
  <a href="<?=$PAGE['prevlink']?>">
    <button class="btn btn-primary">Prev Page</button>
  </a>
  <a href="<?=$PAGE['nextlink']?>">
    <button class="btn btn-primary float-end">Next Page</button>
  </a>
</div>
</div>

<?php endif;?>