<?php require 'Session.class.php' ?>
<?php Session::start(); ?>
<?php if (isset($_GET['action'])) {
 if ($_GET['action'] == "logout") {
 Session::logout();
 }
}

if (!Session::get("username")) {
 $name = "Matthieu";
 Session::set("username", $name);
 $tries = 0;
 Session::set("usertries", $tries);
}

?>


<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $currentMode = isset($_GET['games']) ? $_GET['games'] : array();
    $previousMode = Session::get("previous_mode");
    if ($currentMode != $previousMode) {
        Session::set("usertries", 0);
        Session::set("previous_mode", $currentMode);
    }
}
?>

<?php
$games = [
 "first" => "fixed", "second" => "random", "third" => "drunk"
];
?>
<?php if (isset($_GET['games'])) {
 var_dump($_GET['games']);
} ?>
<?php require 'header.php' ?>
<?php require 'jeu.php' ?>

<?php
 if( isset($_GET['games'])){
 if(count($_GET['games']) > 1){
 $allow = false;
?>
<div class="alert alert-danger">
 <?php echo "Vous ne pouvez pas choisir plus d'un jeu" ?></div>
<?php }} ?>

<?php
$jeu = new Jeu;
$jeu->deviner(isset($_GET['chiffre']) ? $_GET['chiffre'] : NULL);
?>
<div class="alert alert-info">
 <?= 'nb essais:' . Session::get("usertries") ?></div>

<?php if ($jeu->getMessage() == 1) : ?>
 <div class="alert alert-danger">
 <?= "trop grand" ?> 
 </div>

<?php elseif ($jeu->getMessage() == 2) : ?>
 <div class="alert alert-danger">
 <?= "trop petit" ?> 
 </div>
<?php elseif ($jeu->getMessage() == 0) : ?>
 <div class="alert alert-success">
 <?= "Bravo" ?>
 </div>
<?php endif ?>


<main role="main" class="container">
 <form class="form-inline my-2 my-lg-4" action="index.php" method="GET">
 <?php foreach ($games as $game => $type) : ?>
 <div class="form-check">
 <label>
 <input type="checkbox" class="form-check-input" name="games[]" value="<?= $game ?>" <?php if(isset($_GET['games']) && in_array($game, $_GET['games'])) echo "checked"; ?>> 
 <?= $type ?>
 </label>
 </div>

 <?php endforeach; ?>
 <input class="form-control mr-sm-2" type="number" placeholder="entre 1 et 100" name="chiffre" value="<?= $jeu->getValue() ?>">

 <button class="btn btn-secondary my-2 my-sm-0" type="submit">Devinez</button>
 </form>
</main>
<?php require 'footer.php' ?>
