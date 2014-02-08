<!DOCTYPE html >
<html lang="<?php echo SITE_LANG ?>">
<head>
<title><?php print $head_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="cache-control" content="no-cache">
<meta http-equiv="expires" content="0">
    <?php print $head ?>
    <?php print $styles ?>
    <?php print $scripts ?>

    
</head>

<body>
<?php echo $this->load->view($pagename) ?>

</body>
</html>
