<?php
session_start();

if(!isset($_SESSION['logado'])):
    header("location: ../login_novo.php");
endif;

if(isset($_SESSION['mensagem'])): ?>
      
<script>
    window.onload = function(){
        M.toast({html: '<?php echo $_SESSION['mensagem']; ?>'});
    };
</script>
    
<?php
endif;
//session_unset();
?>
