<html>
<title>Bayar Bae Lah </title>
  <head>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script type="text/javascript"
            src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="<SB-Mid-client-3-1RTERX3NmmbDzK>"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
  </head>
  <body>

    <!-- Just an image -->
  <nav class="navbar navbar-light bg-light">
    <a class="navbar-brand" href="#">
      <img src="<?=base_url()?>asset/image/hallo.png" width="30" height="30" alt="" loading="lazy">
    </a>
  </nav>

    <div class="container">
      <form id="payment-form" method="post" action="<?=site_url()?>/snap/finish">
        <input type="hidden" name="result_type" id="result-type" value=""></div>
        <input type="hidden" name="result_data" id="result-data" value=""></div>
             <label for="name">Nama siswa</label>
              <div class="from-grup">
                <input type="text" name="nama" id="nama" class="form-control" required>
              </div>

              <label for="kelas">Kelas</label>
              <div class="form-grup">
                <select name="kelas" id="kelas"  class="form-control" required>
                  <option value="1">11 TKJ 1</option>
                  <option value="2">12 TJK 2 </option>
                  <option value="3">12 TKJ 3 </option>
                </select>
              </div>

              <label for="alamat">Alamat</label>
              <div class="from-grup">
                <input type="text" name="alamat" id="alamat" class="form-control" required>
              </div>

              <label for="email">email</label>
              <div class="from-grup">
                <input type="text" name="email" id="email" class="form-control" required>
              </div>

              <label for="hp">Nomor Hp </label>
              <div class="form-grup">
                <input type="number" name="hp" id="hp" class="form-control" required>
              </div>

              <label for="jmlbayar">Jumlah Pembayaran </label>
              <div class="form-grup">
                <input type="number" name="jmlbayar" id="jmlbayar" class="form-control" required>
              </div>

        <button id="pay-button">Pay!</button>
      </form>
    </div>
     
    <script type="text/javascript">
  
    $('#pay-button').click(function (event) {
      event.preventDefault();
      $(this).attr("disabled", "disabled");

      var email = $('#email').val();
      var alamat = $('#alamat').val();
      var hp   = $('#hp').val();
      var nama = $('#nama').val();
      var kelas = $('#kelas').val();
      var jmlbayar = $('#jmlbayar').val();
    
    $.ajax({
      type : 'POST',
      url: '<?=site_url()?>/snap/token',
      data :{
        nama:nama, 
        kelas :kelas,
        hp : hp,
        email : email,
        alamat : alamat ,
        jmlbayar : jmlbayar
      },
      cache: false,

      success: function(data) {
        //location = data;

        console.log('token = '+data);
        
        var resultType = document.getElementById('result-type');
        var resultData = document.getElementById('result-data');

        function changeResult(type,data){
          $("#result-type").val(type);
          $("#result-data").val(JSON.stringify(data));
          //resultType.innerHTML = type;
          //resultData.innerHTML = JSON.stringify(data);
        }

        snap.pay(data, {
          
          onSuccess: function(result){
            changeResult('success', result);
            console.log(result.status_message);
            console.log(result);
            $("#payment-form").submit();
          },
          onPending: function(result){
            changeResult('pending', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          },
          onError: function(result){
            changeResult('error', result);
            console.log(result.status_message);
            $("#payment-form").submit();
          }
        });
      }
    });
  });

  </script>


</body>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js" integrity="sha384-w1Q4orYjBQndcko6MimVbzY0tgp4pWB4lZ7lr30WKz0vr/aWKhXdBNmNb5D92v7s" crossorigin="anonymous"></script>
</html>
