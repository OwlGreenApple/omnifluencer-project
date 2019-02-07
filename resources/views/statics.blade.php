@extends('layouts.app')

@section('content')
<link href="{{ asset('css/style-statics.css') }}" rel="stylesheet">
<script src="{{ asset('js/custom.js') }}"></script>

<script type="text/javascript">
  $(document).ready(function() {
    if("{{$syarat}}"){
      $( ".scroll-syarat" ).trigger( "click" );
    }
  });  
</script>

  <section class="page-title">
    <div class="container">
      <div class="row">
        <div class="col-12">
          <h1>Omnifluencer Information Page</h1>
          <hr class="orn">
          <p class="pg-title">Omnifluencer adalah tool untuk mengukur engagement rate akun instagram. Temukan banyak informasi mengenai Omnifluencer di sini.</p>
        </div>
      </div>
    </div>
  </section>

  <section class="konten">
    <div class="container">
      <div class="row">
        <div class="col-4 d-none d-sm-none d-md-none d-lg-block" id="spy">
          <ul class="nav nav-pills flex-column sticky-top">
            <li class="nav-item"><a class="nav-link smooth-scroll active" href="#scroll1">Tentang Kami</a></li>
            <li class="nav-item"><a class="nav-link smooth-scroll" href="#scroll2">Earnings and Legal Disclaimer</a></li>
            <li class="nav-item"><a class="nav-link smooth-scroll" href="#scroll3">Disclaimer</a></li>
            <li class="nav-item"><a class="nav-link smooth-scroll scroll-syarat" href="#scroll4">Syarat dan Ketentuan</a></li>
          </ul>
        </div>
        <div class="col-lg-8 col-md-12 col-sm-12 scrollspy-example">
          <div class="card" id="scroll1">
            <div class="card-body">
              <h2>Tentang Kami</h2>
              <p>
                Dengan Omnifluencer, Anda bisa mengetahui engagement rate akun Instagram. Anda bisa membandingkan hingga 4 akun Instagram untuk bisa melihat perbandingan langsung. Ini akan membantu Anda dalam memilih influencer yang tepat pada proyek yang sedang dijalankan.
              </p>
            </div>
          </div>
          <div class="card" id="scroll2">
            <div class="card-body">
              <h2>Earnings and Legal Disclaimers</h2>
              <p>
                Kami tidak percaya pada cara yang cepat dan instant. Kami percaya pada kerja keras, nilai luhur dan melayani orang lain. Karena itu, kami membuat program untuk membantu Anda. <br>

                Sebagaimana dinyatakan dalam hukum, kami tidak dapat dan tidak menjamin apapun tentang kemampuan Anda sendiri dalam menghasilkan atau mendapatkan uang dari ide, informasi, program, atau strategi kami. <br>

                Kami tidak mengenal Anda. Apapun yang terjadi, itu karena Anda. Sepakat? Namun, kami di sini siap membantu Anda memberikan strategi terhebat sehingga bisnis Anda bisa maju, lebih cepat. <br>

                Bagaimanapun, tidak ada janji atau jaminan masa depan di halaman ini atau situs web atau email kami. <br>

                Setiap angka keuangan yang direferensikan di sini, atau di situs atau email kami, hanyalah perkiraan atau proyeksi atau hasil di masa lalu, dan tidak boleh dianggap tepat, aktual atau sebagai janji potensi penghasilan - semua angka hanya ilustrasi saja. <br>

                Jika Anda memiliki pertanyaan, kirim email ke support@omniflencer.com. Terima kasih sudah berkunjung. Sampai jumpa dan ingatlah: Anda lebih dekat dari yang Anda kira.
              </p>
            </div>
          </div>
          <div class="card" id="scroll3">
            <div class="card-body">
              <h2>Disclaimer</h2>
              <p>
                Jika Anda memerlukan informasi lebih lanjut atau memiliki pertanyaan tentang disclaimer website kami, jangan ragu menghubungi kami melalui email di support@omnifluencer.com.
              </p>

              <p>
                <b>Disclaimer untuk omnifluencer.com</b>
                <br>
                Semua informasi di website ini diterbitkan dengan itikad baik dan dengan tujuan memberikan informasi umum saja. omnifluencer.com tidak membuat jaminan apa pun tentang kelengkapan, keandalan, dan keakuratan informasi ini. <br>
            
                Tindakan apa pun yang Anda lakukan terkait informasi yang Anda temukan di website ini (omnifluencer.com), sepenuhnya merupakan risiko Anda sendiri. <br>

                omnifluencer.com tidak akan bertanggung jawab atas kerugian dan/atau kerusakan terkait penggunaan website kami. <br>

                Dari website kami, Anda bisa mengunjungi website lain dengan mengikuti tautan tersebut. Meskipun kami menyediakan tautan berkualitas, kami tidak memiliki kendali atas konten website tersebut. Tautan itu juga tidak direkomendasikan untuk semua konten yang ditemukan di website-website ini. Pemilik website dan konten dapat mengubah isi tanpa pemberitahuan secara tiba-tiba sebelum kami memiliki kesempatan menghapus tautan yang bisa saja memburuk. <br>

                Harap perhatikan, bahwa ketika Anda meninggalkan website kami, website lain mungkin memiliki kebijakan privasi dan ketentuan berbeda di luar kendali kami. Harap pastikan untuk memeriksa Kebijakan Privasi dari website ini serta "Syarat dan Ketentuan" mereka sebelum terlibat dalam bisnis apa pun atau mengunggah informasi apa pun. <br>
              </p>
              <p>
                <b>Persetujuan</b> <br>
                Dengan menggunakan website kami, Anda memberikan persetujuan atas disclaimer kami dan menyetujui ketentuan-ketentuannya.
              </p>
              <p>
                <b>Memperbarui</b> <br>
                Disclaimer website ini diperbarui pada: Kamis 31 Januari 2019.
                Jika ada pembaruan dan pengubahan apapun pada dokumen ini, perubahan tersebut akan diposting secara jelas di sini.
              </p>
            </div>
          </div>
          <div class="card" id="scroll4">
            <div class="card-body">
              <h2>Syarat dan Ketentuan</h2>
              <p>
                Selamat datang di website kami. Jika Anda terus menelusuri dan menggunakan website ini, Anda setuju untuk mematuhi dan terikat dengan syarat dan ketentuan penggunaan berikut, yang bersama dengan kebijakan privasi kami mengatur hubungan omnifluencer.com dengan Anda dalam kaitannya dengan situs web ini. Jika Anda tidak setuju dengan bagian apa pun dari syarat dan ketentuan ini, mohon jangan gunakan website kami.
              </p>
              <p>
                Istilah pada omnifluencer.com atau "kami" merujuk kepada pemilik website yang kantornya terdaftar di: <br>
                
                Dian Istana F3/81 <br>
                Surabaya, Jawa Timur <br>
                Indonesia <br>
                
                Istilah "Anda" mengacu pada pengguna atau pemirsa website kami.
              </p>

              <p>
                Penggunaan website ini mengikuti ketentuan penggunaan seperti berikut ini:
              </p>
                <ol>
                  <li>
                    Isi halaman-halaman website ini adalah untuk memberikan informasi umum pada Anda dan hanya untuk penggunaan saja. Isi halaman website dapat berubah tanpa pemberitahuan.
                  </li>
                  <li>
                    Baik kami maupun pihak ketiga tidak memberikan garansi atau jaminan apapun mengenai keakuratan, ketepatan waktu, kinerja, kelengkapan atau kesesuaian informasi dan materi yang ditemukan atau ditawarkan di website ini untuk tujuan tertentu. Anda mengakui bahwa informasi dan materi tersebut mungkin berisi ketidakakuratan atau kesalahan dan kami secara tegas memberikan pengecualian tanggung jawab atas ketidakakuratan atau kesalahan apapun sejauh yang diizinkan oleh hukum.
                  </li>
                  <li>
                    Penggunaan informasi atau materi di website ini sepenuhnya merupakan risiko Anda sendiri dan itu bukan tanggung jawab kami. Tanggung jawab Anda untuk memastikan bahwa setiap produk, layanan, atau informasi yang tersedia melalui website ini memenuhi persyaratan khusus Anda.
                  </li>
                  <li>
                    Website ini berisi materi yang dimiliki oleh atau dilisensikan kepada kami. Materi ini tidak terbatas hanya pada desain, tata letak, tampilan, interface dan grafik.
                  </li>
                  <li>
                    Dilarang memperbanyak selain sesuai dengan pemberitahuan hak cipta, yang merupakan bagian dari syarat dan ketentuan ini.        
                  </li>
                  <li>
                    Semua merek dagang yang dihasilkan di website ini, yang bukan milik, atau dilisensikan kepada operator, diakui di website ini.
                  </li>
                  <li>
                    Penggunaan yang tidak sah dari website ini dapat menimbulkan klaim atas kerusakan dan/atau menjadi tindak pidana.
                  </li>
                  <li>
                    Seiring berjalannya waktu, website ini juga dapat menyertakan tautan ke website lain. Tautan ini disediakan demi kenyamanan Anda untuk memberikan informasi lebih lanjut. Namun ini tidak menandakan bahwa kami mendukung website tersebut. Kami tidak bertanggung jawab atas isi dari website tertaut.
                  </li>
                  <li>
                    Penggunaan Anda atas website ini dan setiap konflik yang timbul dari penggunaan website hormat pada Undang-undang Informasi dan Transaksi Elektronik atau Undang Undang nomor 11 tahun 2008 atau UU ITE.
                  </li>
                  <li>
                    Kami menggunakan cookie agar website ini berguna sebagaimana mestinya. Cookie adalah file teks kecil yang kami letakkan di browser Anda untuk melacak penggunaan website kami tetapi mereka tidak memberi tahu kami siapa Anda sebenarnya.
                  </li>
                  <li>
                    Jika Anda ingin menghapus cookie yang sudah ada di komputer Anda, silakan ke setting software file Anda untuk mencari file atau direktori yang menyimpan cookie.
                  </li>
                  <li>
                    Website ini bukan bagian dari Instagram atau Facebook maupun media sosial lain. Selain itu, website ini tidak didukung oleh Facebook dan Instagram dengan cara apapun. FACEBOOK adalah merek dagang dari FACEBOOK, Inc.
                  </li>
                </ol>
            </div>
          </div>
      </div>
    </div>
  </section>
   
@endsection
