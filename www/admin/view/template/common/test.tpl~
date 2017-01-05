<?php echo $header; ?><?php echo $column_left; ?>
<div id="content">
  <div class="page-header">
    <div class="container-fluid">
      <h1><?php echo $heading_title; ?></h1>
      <ul class="breadcrumb">
        <?php foreach ($breadcrumbs as $breadcrumb) { ?>
        <li><a href="<?php echo $breadcrumb['href']; ?>"><?php echo $breadcrumb['text']; ?></a></li>
        <?php } ?>
      </ul>
    </div>
  </div>
  <div class="container-fluid">
    <?php if ($error_install) { ?>
    <div class="alert alert-danger"><i class="fa fa-exclamation-circle"></i> <?php echo $error_install; ?>
      <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
    <?php } ?>
    <!--_______________________________________-->


    <div class="Sima-Land">
    <H3>Выберите категорию</H3>
    <form name="listCat" method="POST"  action="<?php echo $_SERVER['REQUEST_URI']; ?>">
        <select name='catName'>
            <option>&nbsp;</option>
            <?php
                foreach ($parentCatsArray as $key => $value){
                echo "<option value='$value->id'>$value->name</option>";
            }?>
        </select><br>
        <input type="submit" value="Получить список">
    </form>

    </div>
    <!-_______________________________________-->
  </div>
</div>
<?php echo $footer; ?>
