<!DOCTYPE html>
<html lang="en">
 @include('backend.includes.header')
 <style>

     .tablePoint th{
         border: 0.5px solid;
         padding: 5px 10px;
     }
     .tablePoint td{
         border: 0.5px solid;
         padding: 5px 10px;
         text-align: center;
     }
     .tablePoint{
         min-width: 100%;
     }
     .tablePoint .point{
         border: none;
         outline: none;
         background: #f6f7f9;
         max-width: 70px;
         height: 35px;
     }

 </style>
  <body>
    <!-- .app -->
    <div class="app">
      <!--[if lt IE 10]>
      <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
      <![endif]-->
      <!-- .app-header -->
      @include('backend.includes.sidebar')
      <!-- .app-main -->
      <main class="app-main">
        <!-- .wrapper -->
        @yield('contents')
        @include('backend.includes.main_footer')
        <!-- /.wrapper -->
      </main><!-- /.app-main -->
    </div><!-- /.app -->
   @yield('modals')
   @include('backend.includes.footer')
  </body>
</html>
