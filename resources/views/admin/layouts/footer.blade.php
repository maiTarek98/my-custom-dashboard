
        </div>
        <!-- / Layout page -->
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
    </div>
    <!-- / Layout wrapper -->

    <!-- Core JS -->
    <!-- build:js assets/vendor/js/core.js -->
    <script src="{{url('/dashboard/')}}/assets/vendor/libs/jquery/jquery.js"></script>
    <script src="{{url('/dashboard/')}}/assets/vendor/libs/popper/popper.js"></script>
    <script src="{{url('/dashboard/')}}/assets/vendor/js/bootstrap.js"></script>
    <script src="{{url('/dashboard/')}}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="{{url('/dashboard/')}}/assets/js/validatorjs.min.js"></script>

    <script src="{{url('/dashboard/')}}/assets/vendor/js/menu.js"></script>
    <!-- endbuild -->
    @stack('custom-js')
<!-- JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>
    <script>
        $(document).ready(function() {
            toastr.options.timeOut = 10000;
            @if (Session::has('error'))
                toastr.error('{{ Session::get('error') }}');
            @elseif(Session::has('success'))
                toastr.success('{{ Session::get('success') }}');
            @endif
        });
$("#validate-form").validate({ignore: [],});
document.addEventListener("DOMContentLoaded", function(event) {
   $.extend( $.validator.messages, {
        required: "This field is required",
        remote: "يرجى تصحيح هذا الحقل للمتابعة",
        email: "Enter a valid email",
        url: "رجاء إدخال عنوان موقع إلكتروني صحيح",
        date: "رجاء إدخال تاريخ صحيح",
        dateISO: "رجاء إدخال تاريخ صحيح (ISO)",
        number: "رجاء إدخال عدد بطريقة صحيحة",
        digits: "رجاء إدخال أرقام فقط",
        creditcard: "رجاء إدخال رقم بطاقة ائتمان صحيح",
        equalTo: "رجاء إدخال نفس القيمة",
        extension: "رجاء إدخال ملف بامتداد موافق عليه",
        maxlength: $.validator.format( "الحد الأقصى لعدد الحروف هو {0}" ),
        minlength: $.validator.format( "الحد الأدنى لعدد الحروف هو {0}" ),
        rangelength: $.validator.format( "عدد الحروف يجب أن يكون بين {0} و {1}" ),
        range: $.validator.format( "رجاء إدخال عدد قيمته بين {0} و {1}" ),
        max: $.validator.format( "رجاء إدخال عدد أقل من أو يساوي {0}" ),
        min: $.validator.format( "رجاء إدخال عدد أكبر من أو يساوي {0}" )
    });
});
    </script>

    <!-- Vendors JS -->
    <script src="{{url('/dashboard/')}}/assets/vendor/libs/apex-charts/apexcharts.js"></script>

    <!-- Main JS -->
    <script src="{{url('/dashboard/')}}/assets/js/main.js"></script>

    <!-- Page JS -->
    <script src="{{url('/dashboard/')}}/assets/js/dashboards-analytics.js"></script>

    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
  </body>
</html>
