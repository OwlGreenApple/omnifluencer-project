@if(Auth::user()->logo!=null and Auth::user()->membership=='premium')
      <img src="{{asset('design/logobrand.png')}}" class="logo-footer" style="bottom:-180px">
    @endif  

    <span class="saved-on-footer" style="bottom:-180px">
      <!--{{url('/')}} | calculated on {{ date("d F Y") }}-->
      www.omnifluencer.com | calculated on {{ date("d F Y") }}
    </span>