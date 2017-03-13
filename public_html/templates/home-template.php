<?php if ($_SESSION["profile"]){?>
<sidenav ></sidenav>
<?php }?>

<div>
	Welcome TO SPROUT SWAP!!!!
	<post ngFor="let post of posts" [postInfo]="post"></post>
</div>