<script type="text/javascript">

    window.onload = (event)=> {
     let myAlert = document.querySelector('.toast');
     let bsAlert = new  bootstrap.Toast(myAlert);
     bsAlert.show();
    }
  
</script>

<style>
    .toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
    }
    .toast{
      background: #e55764;
      color: white;
    }
    .iconToasts{
      font-size: 20px;
    }
</style>

<div class="toast-container">

  <div class="toast align-items-center" role="alert" aria-live="assertive" aria-atomic="true" data-bs-delay="10000">
    <div class="d-flex">
      <div class="toast-body d-flex align-items-center">
        <ion-icon style="font-size: 25px;" name="close-circle-outline"></ion-icon>
        <span style="font-size: 15px;"><?= $_SESSION['error_message'] ?></span>
      </div>
      <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
  </div>

</div>
