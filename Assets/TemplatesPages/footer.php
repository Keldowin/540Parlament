<footer class="footer mt-auto py-3 bg-light">
    <div class="container">
      <span class="text-muted">Сайт сделал Иванов Пётр для парламента 540</span>
    </div>
  </footer>
  <script>
  const toastTrigger = document.getElementById("liveToastBtn");
  const toastLive = document.getElementById("liveToast");
  console.log(toastLive, toastTrigger);
  if (toastTrigger) {
      const toast = new bootstrap.Toast(toastLive);
      toast.show();
  }
  </script>
  </body>
</html>
<!-- Site made by PeterIvanov (Keldowin) 2022 -->