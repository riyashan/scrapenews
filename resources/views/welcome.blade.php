<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <link href="https://cdn.jsdelivr.net/npm/toastr@2.1.4/build/toastr.min.css" rel="stylesheet">


        <!-- Styles -->
        <style>
            /*! normalize.css v8.0.1 | MIT License | github.com/necolas/normalize.css */html{line-height:1.15;-webkit-text-size-adjust:100%}body{margin:0}a{background-color:transparent}[hidden]{display:none}html{font-family:system-ui,-apple-system,BlinkMacSystemFont,Segoe UI,Roboto,Helvetica Neue,Arial,Noto Sans,sans-serif,Apple Color Emoji,Segoe UI Emoji,Segoe UI Symbol,Noto Color Emoji;line-height:1.5}*,:after,:before{box-sizing:border-box;border:0 solid #e2e8f0}a{color:inherit;text-decoration:inherit}svg,video{display:block;vertical-align:middle}video{max-width:100%;height:auto}.bg-white{--tw-bg-opacity: 1;background-color:rgb(255 255 255 / var(--tw-bg-opacity))}.bg-gray-100{--tw-bg-opacity: 1;background-color:rgb(243 244 246 / var(--tw-bg-opacity))}.border-gray-200{--tw-border-opacity: 1;border-color:rgb(229 231 235 / var(--tw-border-opacity))}.border-t{border-top-width:1px}.flex{display:flex}.grid{display:grid}.hidden{display:none}.items-center{align-items:center}.justify-center{justify-content:center}.font-semibold{font-weight:600}.h-5{height:1.25rem}.h-8{height:2rem}.h-16{height:4rem}.text-sm{font-size:.875rem}.text-lg{font-size:1.125rem}.leading-7{line-height:1.75rem}.mx-auto{margin-left:auto;margin-right:auto}.ml-1{margin-left:.25rem}.mt-2{margin-top:.5rem}.mr-2{margin-right:.5rem}.ml-2{margin-left:.5rem}.mt-4{margin-top:1rem}.ml-4{margin-left:1rem}.mt-8{margin-top:2rem}.ml-12{margin-left:3rem}.-mt-px{margin-top:-1px}.max-w-6xl{max-width:72rem}.min-h-screen{min-height:100vh}.overflow-hidden{overflow:hidden}.p-6{padding:1.5rem}.py-4{padding-top:1rem;padding-bottom:1rem}.px-6{padding-left:1.5rem;padding-right:1.5rem}.pt-8{padding-top:2rem}.fixed{position:fixed}.relative{position:relative}.top-0{top:0}.right-0{right:0}.shadow{--tw-shadow: 0 1px 3px 0 rgb(0 0 0 / .1), 0 1px 2px -1px rgb(0 0 0 / .1);--tw-shadow-colored: 0 1px 3px 0 var(--tw-shadow-color), 0 1px 2px -1px var(--tw-shadow-color);box-shadow:var(--tw-ring-offset-shadow, 0 0 #0000),var(--tw-ring-shadow, 0 0 #0000),var(--tw-shadow)}.text-center{text-align:center}.text-gray-200{--tw-text-opacity: 1;color:rgb(229 231 235 / var(--tw-text-opacity))}.text-gray-300{--tw-text-opacity: 1;color:rgb(209 213 219 / var(--tw-text-opacity))}.text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}.text-gray-600{--tw-text-opacity: 1;color:rgb(75 85 99 / var(--tw-text-opacity))}.text-gray-700{--tw-text-opacity: 1;color:rgb(55 65 81 / var(--tw-text-opacity))}.text-gray-900{--tw-text-opacity: 1;color:rgb(17 24 39 / var(--tw-text-opacity))}.underline{text-decoration:underline}.antialiased{-webkit-font-smoothing:antialiased;-moz-osx-font-smoothing:grayscale}.w-5{width:1.25rem}.w-8{width:2rem}.w-auto{width:auto}.grid-cols-1{grid-template-columns:repeat(1,minmax(0,1fr))}@media (min-width:640px){.sm\:rounded-lg{border-radius:.5rem}.sm\:block{display:block}.sm\:items-center{align-items:center}.sm\:justify-start{justify-content:flex-start}.sm\:justify-between{justify-content:space-between}.sm\:h-20{height:5rem}.sm\:ml-0{margin-left:0}.sm\:px-6{padding-left:1.5rem;padding-right:1.5rem}.sm\:pt-0{padding-top:0}.sm\:text-left{text-align:left}.sm\:text-right{text-align:right}}@media (min-width:768px){.md\:border-t-0{border-top-width:0}.md\:border-l{border-left-width:1px}.md\:grid-cols-2{grid-template-columns:repeat(2,minmax(0,1fr))}}@media (min-width:1024px){.lg\:px-8{padding-left:2rem;padding-right:2rem}}@media (prefers-color-scheme:dark){.dark\:bg-gray-800{--tw-bg-opacity: 1;background-color:rgb(31 41 55 / var(--tw-bg-opacity))}.dark\:bg-gray-900{--tw-bg-opacity: 1;background-color:rgb(17 24 39 / var(--tw-bg-opacity))}.dark\:border-gray-700{--tw-border-opacity: 1;border-color:rgb(55 65 81 / var(--tw-border-opacity))}.dark\:text-white{--tw-text-opacity: 1;color:rgb(255 255 255 / var(--tw-text-opacity))}.dark\:text-gray-400{--tw-text-opacity: 1;color:rgb(156 163 175 / var(--tw-text-opacity))}.dark\:text-gray-500{--tw-text-opacity: 1;color:rgb(107 114 128 / var(--tw-text-opacity))}}
        </style>

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
    </head>
    <body>
        

            <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
                <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="/index">Scrape Tool</a>
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
                          <a class="nav-link active" aria-current="page" href="home.php">
                            <span data-feather="home"></span>
                            Home
                          </a>
                        </li>
                        <li class="nav-item">
                          <a class="nav-link" href="/scrape">
                            <span data-feather="globe"></span>
                            Scrape
                          </a>
                        </li>
                      </ul>
              
                    </div>
                  </nav>
              
                  <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                      <h1 class="h2">Home</h1>
                      <div class="btn-toolbar mb-2 mb-md-0">
                       
                      </div>
                    </div>
              
                  
                    <h2>News Paper</h2>
                    <div class="row">
                    <div class="loader">
                        <center>
                            <img class="loading-image" src="app/public/images/spin.gif" height="80px;", width="80px;"alt="loading..">
                        </center>
                    </div>
                    <form enctype="multipart/form-data" id="news">
                      <div class='float-end mb-2 mb-md-0'>
                          <button name='delete_sel' id='delete_sel' class="btn btn-danger btn-sm float-end">DELETE SELECTED</button>
                          <br/>
                          <br/>
                      </div>
                      <div class="col-xl-12">
                          <br/>
                          <br/>
                        <div class="table-responsive">
                          <table id="newspaper" class="table table-striped nowrap" cellspacing="0" style="width:100%">
                              <thead>
                                  <tr>
                                      <th><input name="select_all" value="1" id="example-select-all" type="checkbox" /></th>
                                      <th>Date</th>
                                      <th>News Paper</th>
                                      <th>Cover Picture</th>
                                      <th>Actions</th>
                                  </tr>
                              </thead>
                          </table>
                        </div>
                      </div>
                  </form>
                    </div>
                  </main>
                </div>
              </div>

            <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/toastr@2.1.4/toastr.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
            <script src="js/dashboard.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            
            <script>
          /*     $(function() {
                         $('newspaper').DataTable({
                         processing: true,
                         serverSide: true,
                         deferRender: true,
                         ajax: '{{ url('newsdata') }}',
          
                         columns: [
                                  { data: 'id', name: 'id' },
                               {{--     {
                                  data: 'image',
                                  name: 'image',
                                      render: function ( data, type, row ) {
                                      var uniqid = Date.now();
                                      var html = '<img class="img-responsive" src="'+ data +'?i='+uniqid+'" />';
                                      return html;
                                      },
                                  },  --}}
          
                                  { data: 'image', name: 'image', render:function(data, type, row){
                                  return "<span class='hiddentxt'><a href="+ data +">Image</a></span><span class='hiddenimg'><img src="+ data +" width='250'></span>"
                                  }},
          
                                  { data: 'cardname',name: 'cardname' },
                                  { data: 'name', name: 'name' },
                                  { data: 'created_at', name: 'created_at' },
                                  { data: 'creatername', name: 'creatername' },
                                  { data: 'updated_at', name: 'updated_at' },
                                  { data: 'editname', name: 'editname' }
                               ]
                      });
                   }); */
          </script>


            <script>
              $(document).ready(function () {
                  var table = $('#newspaper').DataTable({
                      "scrollX": true,
                      "scrollY": 900,
                      "processing": true,
                      "serverSide": true,
                      "deferRender": true,
                      "ajax":{
                          url :'{{ url('newsdata') }}', // json datasource
                          type: "get",  // method  , by default get
                      },
                      "order": [[1, "DESC"]],
                      "columns": [
                        { data: 'id', name: 'id' }, 
                        { data: 'news_date',name: 'news_date' },
                        { data: 'news_paper_type', name: 'news_paper_type' },
                        { data: 'cover_pic', name: 'cover_pic'},
                        { data: 'action', name: 'action' },
                      /*   { data: 'cover_pic', name: 'cover_pic', render:function(data, type, row){
                          return "<img src="+ data +" width='150' height='200'>"
                        }}, */
              
                      ],
                      "columnDefs": [
                          {
                              "targets": 0,
                              'searchable':false,
                              "orderable": false,
                              'className': 'dt-body-center',
                              'render': function (data, type, full, meta){
                                  return '<input type="checkbox" name="id[]" value="' 
                                      + $('<div/>').text(data).html() + '">';
                              }
                          }, //column specific order and spec
                          {
                              "targets": 1,
                              "orderable": true
                          }, //column specific order and spec
                          {
                              "targets": 2,
                              "orderable": true
                          }, 
                          {
                              "targets": 3,
                              "orderable": false
                          }, 
                          {
                              "targets": 4,
                              "orderable": false
                          }, 
                      ]
                      
                      , "fnDrawCallback": function (oSettings, json) {
                      }
                      , "deferRender": true
                  });
              
                   // Handle click on "Select all" control
                   $('#example-select-all').on('click', function(){
                    // Check/uncheck all checkboxes in the table
                        var rows = table.rows({ 'search': 'applied' }).nodes();
                        $('input[type="checkbox"]', rows).prop('checked', this.checked);
                    });
              
                    // Handle click on checkbox to set state of "Select all" control
                    $('#example tbody').on('change', 'input[type="checkbox"]', function(){
                    // If checkbox is not checked
                        if(!this.checked){
                            var el = $('#example-select-all').get(0);
                            // If "Select all" control is checked and has 'indeterminate' property
                            if(el && el.checked && ('indeterminate' in el)){
                                // Set visual state of "Select all" control 
                                // as 'indeterminate'
                                el.indeterminate = true;
                            }
                        }
                    });
              
                    $('#news').on('submit', function(e){
                        var form = this;
                        //alert('yes');
                        // Iterate over all checkboxes in the table
                        table.$('input[type="checkbox"]').each(function(){
                            // If checkbox doesn't exist in DOM
                            if(!$.contains(document, this)){
                                // If checkbox is checked
                                if(this.checked){
                                    // Create a hidden element 
                                    $(form).append(
                                    $('<input>')
                                        .attr('type', 'hidden')
                                        .attr('name', this.name)
                                        .val(this.value)
                                    );
                                }
                            } 
                        });
              
                        // Output form data to a console
                        $('#example-console').text($(form).serialize()); 
                        console.log("Form submission", $(form).serialize()); 
                                
                        // Prevent actual form submission
                        e.preventDefault();
                    });
              });
              </script>

<script>
  function deleteRow(ecrp, type, date) {
      const swalWithBootstrapButtons = Swal.mixin({
          customClass: {
              confirmButton: 'btn btn-success',
              cancelButton: 'btn btn-danger'
          },
          buttonsStyling: false
      })

      swalWithBootstrapButtons.fire({
          title: 'Are you sure want to Remove this Record?',
          text: "You won't be able to revert this!",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonText: 'Yes, delete it!',
          cancelButtonText: 'No, cancel!',
          reverseButtons: true
      }).then((result) => {
          if (result.isConfirmed) {
              $.ajax({
                  type: "POST",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: "/deleterec",
                  data: {
                      ecrp: ecrp,
                      type: type,
                      date: date
                  }
                  , cache: false
                  , success: function (data) {
                      if($.trim(data)==='Success') {
                          toastr.success('Successfully Deleted', 'Success Alert', {timeOut: 3000,progressBar: true,preventDuplicates: true})
                          var t = $('#newspaper').DataTable();
                          t.ajax.reload(null, false);
                      }else if($.trim(data)==='Empty') {
                          toastr.error('Could not finding the Record', 'Error Alert', {timeOut: 3000,progressBar: true, preventDuplicates: true})
                      //swal("Ooooops", "Could not finding the Record", "error");
                      } 
                  },
              });
          
          } else if (
              /* Read more about handling dismissals below */
              result.dismiss === Swal.DismissReason.cancel
          ) {
              swalWithBootstrapButtons.fire(
              'Cancelled',
              'Your imaginary file is safe :)',
              'error'
              )
          }
      })
  }

  $(document).ready(function () {
      $('#delete_sel').on('click', function(){
        //alert('yes');
          var str=$('form input:not([type="checkbox"])').serialize();
          var datastring = $("#news").serialize();
          console.log(datastring);
          if(datastring.length==0){
              toastr.error('Please Select The Check Box', 'Error Alert', {timeOut: 3000,progressBar: true, preventDuplicates: true})
          }else{
              $.ajax({
                  type: "POST",
                  headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                  url: "/deletemultip",
                  data: datastring,
                  success: function(data) {
                      console.log(data);
                      if($.trim(data)==='Success') {
                        toastr.success('Successfully Deleted', 'Success Alert', {timeOut: 3000,progressBar: true,preventDuplicates: true})
                          //window.location.assign('create_do.php?'+datastring);
                          var t = $('#newspaper').DataTable();
                          t.ajax.reload(null, false);
                      }else if($.trim(data)==='Invalid') {
                          toastr.error('Invalid Records', 'Error Alert', {timeOut: 3000,progressBar: true, preventDuplicates: true})
                      }
                  },
                
              });
          }
      })
  });
</script>
</body>
</html>
