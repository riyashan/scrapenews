<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Scrape</title>
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <style>
        body {
        font-size: .875rem;
        }

        .feather {
        width: 16px;
        height: 16px;
        vertical-align: text-bottom;
        }

        /*
        * Sidebar
        */

        .sidebar {
        position: fixed;
        top: 0;
        /* rtl:raw:
        right: 0;
        */
        bottom: 0;
        /* rtl:remove */
        left: 0;
        z-index: 100; /* Behind the navbar */
        padding: 48px 0 0; /* Height of navbar */
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1);
        }

        @media (max-width: 767.98px) {
        .sidebar {
            top: 5rem;
        }
        }

        .sidebar-sticky {
        position: relative;
        top: 0;
        height: calc(100vh - 48px);
        padding-top: .5rem;
        overflow-x: hidden;
        overflow-y: auto; /* Scrollable contents if viewport is shorter than content. */
        }

        .sidebar .nav-link {
        font-weight: 500;
        color: #333;
        }

        .sidebar .nav-link .feather {
        margin-right: 4px;
        color: #727272;
        }

        .sidebar .nav-link.active {
        color: #2470dc;
        }

        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather {
        color: inherit;
        }

        .sidebar-heading {
        font-size: .75rem;
        text-transform: uppercase;
        }

        /*
        * Navbar
        */

        .navbar-brand {
        padding-top: .75rem;
        padding-bottom: .75rem;
        font-size: 1rem;
        background-color: rgba(0, 0, 0, .25);
        box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25);
        }

        .navbar .navbar-toggler {
        top: .25rem;
        right: 1rem;
        }

        .navbar .form-control {
        padding: .75rem 1rem;
        border-width: 0;
        border-radius: 0;
        }

        .form-control-dark {
        color: #fff;
        background-color: rgba(255, 255, 255, .1);
        border-color: rgba(255, 255, 255, .1);
        }

        .form-control-dark:focus {
        border-color: transparent;
        box-shadow: 0 0 0 3px rgba(255, 255, 255, .25);
        }

        .loading-image {
          position: absolute;
          top: 50%;
          left: 50%;
          z-index: 10;
        }
        .loader
        {
            display: none;
            width:200px;
            height: 200px;
            position: fixed;
            top: 50%;
            left: 50%;
            text-align:center;
            margin-left: -50px;
            margin-top: -100px;
            z-index:2;
            overflow: auto;
        }

    </style>

    
    <!-- Custom styles for this template -->
    <link href="css/dashboard.css" rel="stylesheet">
  </head>
  <body>
    
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
  <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="index.php">Scrape Tool</a>
  <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search">
  <div class="navbar-nav">
    <div class="nav-item text-nowrap">
      <a class="nav-link px-3" href="logout.php">Sign out</a>
    </div>
  </div>
</header>

<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link" href="/">
              <span data-feather="home"></span>
              Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="/scrape">
              <span data-feather="globe"></span>
              Scrape
            </a>
          </li>
        </ul>

      </div>
    </nav>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Scrape</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
         
        </div>
      </div>

        <h2>News Paper</h2>
        <form id="scrape" action="#" method="post">
            <div class="row">
                <div class="col-sm-6">
                    <h6>SELECT THE DATE</h6>
                    <div class="input-group">
                    <input type="text" id="date" name="date" class="form-control" placeholder="Please choose date...">
                    </div>
                </div>

                <div class="col-sm-6">
                    <h6>SELECT NEWS PAPER</h6>
                    <div class="input-group">
                    <select name="news_type" id="news_type" class="form-control" required>
                        <option value="1">NST</option>
                        <option value="2">STAR</option>
                        <option value="3">ISSUU</option>
                        <option value="4">SCRIBD</option>
                    </select>
                    </div>
                </div>
            </div>

            <div class="row" id="url_div">
              <div class="col-sm-8">
              <br/><br/>
                <h6>URL</h6>
                <div class="input-group">
                <input type="text" id="url" name="url" class="form-control" placeholder="URL">
                </div>
              </div>
            </div>
            <br/>
            <div class="mt-4 text-center">
                <button type="submit" id="submit" name="submit" class="btn btn-primary">Scrape</button>
            </div>
            <hr class="col-12 col-md-12 mb-5">
            <div id="status"></div>
        </form>
    </main>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="js/dashboard.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-material-datetimepicker/2.7.1/js/bootstrap-material-datetimepicker.min.js"></script>

<script>
$('#date').bootstrapMaterialDatePicker({
    format: 'YYYY-MM-DD',
    useCurrent: false,
    maxDate: moment(),
    clearButton: true,
    weekStart: 1,
    time: false
});   

$("#scrape").on('submit',(function(e){ 
    e.preventDefault();
    var selDate = $('#date').val();
    var selNewsType = $('#news_type').val();
    var url = $('#url').val();
    $.ajax({
        url: "/scrapedata",
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        type: "POST",
        data:  new FormData(this),
        contentType: false,
        cache: false,
        processData:false,
        success: function(data){
            console.log(data);
            if ($.trim(data) == "Success") {
                $('#status').html('Loading...Making PDF File...');
                if(selNewsType != "3"){
                  makepdf(selDate, selNewsType);
                }else{
                  makepdfozark(selNewsType, url);
                }
            } 
            if ($.trim(data) == "Empty Result") {
                $('#status').html('Cannot Find');
            } 
            if ($.trim(data) == "Invalid") {
                $('#status').html('Invalid Records');
            } 
            if ($.trim(data) == "Exist") {
                $('#status').html('Already Exist');
            } 
        },
        beforeSend: function(){
            $('#status').html('Loading...Downloading...');
        },
        complete: function(){
            //$('.loader').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.log(textStatus, errorThrown);
        }     	 	        
    });
}));

function makepdf(selDate, selNewsType){
  $.ajax({
      type: "POST",
      url: "/makepdf",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      cache: false,
      data: {selDate : selDate, selNewsType : selNewsType},
      success: function(data){
        if ($.trim(data) == "Success") {
          $('#status').html('Completed');
        }
      },
      beforeSend: function(){
        $('#status').html('Loading...Making PDF File...');
      },
      complete: function(){
          //$('.loader').hide();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
      }    
  });
}

function makepdfozark(selNewsType, url){
  $.ajax({
      type: "POST",
      url: "/makepdf",
      headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
      cache: false,
      data: {selNewsType : selNewsType, url : url},
      success: function(data){
        if ($.trim(data) == "Success") {
          $('#status').html('Completed');
        }
      },
      beforeSend: function(){
        $('#status').html('Loading...Making PDF File...');
      },
      complete: function(){
          //$('.loader').hide();
      },
      error: function(jqXHR, textStatus, errorThrown) {
      console.log(textStatus, errorThrown);
      }    
  });
}

$('#news_type').change(function(){
    var news_type = $(this).val();
    if(news_type == '3' || news_type == '4'){
      $("#url_div").show();
    }else{
      $("#url_div").hide();
    }
})
</script>


  </body>
</html>
