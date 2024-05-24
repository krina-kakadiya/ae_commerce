<!DOCTYPE html>
<html lang="en">
  @include('admin.layout.head')
<body>
  @include('admin.layout.header')
  @include('admin.layout.sidebar')
  <main id="main" class="main">
    @yield('container')
  </main>
  @include('admin.layout.footer')
  @include('admin.layout.script')
  @yield('script')
  @include('notification.iziToast')
</body>

</html>