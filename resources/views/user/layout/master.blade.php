<!DOCTYPE html>
<html>
@include('user.layout.head')

<body>
  @include('user.layout.header')
  <div id="all">
    <div id="content">
      @yield('container')
    </div>
  </div>
  @include('user.layout.footer')
  @include('user.layout.script')
  @yield('script')
</body>

</html>