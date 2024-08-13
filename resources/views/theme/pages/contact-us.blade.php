@extends('theme.main')



@section('pagecss')

@endsection



@section('content')

<div class="container topmargin-lg bottommargin-lg">

    <div class="row">

        <div class="col-12 mb-5">

            {!! $page->contents !!}

        </div>

        <div class="col-12">

            <h3>Leave Us a Message</h3>

            <p><strong>Note:</strong> Please do not leave required fields (*) empty.</p>

            <div class="form-style fs-sm">

                <form id="contact_form" action="{{ route('contact-us') }}" method="POST">

                    @csrf
                    <div class="g-recaptcha" data-sitekey="YOUR_PRIVATE_KEY" data-callback="recaptchaCallback"></div>
                    
                    <div class="row">
                    
                    <div class="form-group col-md-4">

                        <label for="fullName" class="fs-6 fw-semibold text-initial nols">Full Name <span class="text-danger">*</span></label>

                        <input type="text" id="fullName" class="form-control form-input" name="name" placeholder="First and Last Name" required/>

                    </div>



                    <div class="form-group col-md-4">

                        <label for="emailAddress" class="fs-6 fw-semibold text-initial nols">E-mail Address <span class="text-danger">*</span></label>

                        <input type="email" id="emailAddress" class="form-control form-input" name="email" placeholder="hello@email.com" required/>

                    </div>

                    <div class="form-group col-md-4">

                        <label for="contactNumber" class="fs-6 fw-semibold text-initial nols">Contact Number <span class="text-danger">*</span></label>

                        <input type="number" id="contactNumber" class="form-control form-input" name="contact" placeholder="Landline or Mobile" required/>

                    </div>

                    <div class="form-group col-12">

                        <label for="message" class="fs-6 fw-semibold text-initial nols">Message <span class="text-danger">*</span></label>

                        <textarea name="message" id="message" class="form-control form-input textarea" rows="5" required></textarea>

                    </div>
                    
                    </div>

                    <div class="form-group">

                        <div class="g-recaptcha recaptcha mt-2" name="g-recaptcha-response" id="g-recaptcha-response" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>

                        @if ($errors->has('g-recaptcha-response'))

                            <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span>

                        @endif

                    </div>

                    <div class="row g-2">

                        <div class="col-md-6">

                            <button type="submit" class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large text-center" id="btnSubmit" style="background-color:#781049"> Submit </button>

                            <a href="javascript:void(0)" class="button button-circle button-dark border-bottom ms-0 text-initial nols fw-normal button-large  text-center" onclick="resetForm()">Reset</a>

                            <!-- <a href="javascript:void(0)" class="button button-circle border-bottom ms-0 text-initial nols fw-normal button-large d-block text-center" onclick="document.getElementById('contact_form').submit()">Submit</a> -->

                        </div>

                    </div>


                    {{-- hidden inputs --}}

                    <div class="form-group" style="display:none;">

                        <input type="text" id="subject" class="form-control form-input" name="subject" placeholder="Enter Subject" value="Inquiry" required/>

                        <input type="text" id="services" class="form-control form-input" name="services" placeholder="Enter Subject" value="Design" required/>

                    </div>

                </form>

                {{-- captcha script --}}

                <!-- <script src="https://www.google.com/recaptcha/api.js" async defer></script> -->

            </div>



        </div>

    </div>

</div>



@endsection



@section('pagejs')

<script>

    $('#contact_form').submit(function (evt) {
        document.getElementById('contact_form').submit()

        // let recaptcha = $("#g-recaptcha-response").val();

        // if (recaptcha === "") {

        //     evt.preventDefault();

        //     $('#catpchaError').show();

        //     return false;

        // }

    });



    // $('#contactUsForm').submit(function (evt) {

    //     let recaptcha = $("#g-recaptcha-response").val();

    //     if (recaptcha === "") {

    //         evt.preventDefault();

    //         $('#catpchaError').show();

    //         return false;

    //     }

    // });


    /** form validations **/

    $(document).ready(function () {

        //called when key is pressed in textbox

        $('#contact').keypress(function (e) {

            //if the letter is not digit then display error and don't type anything

            var charCode = (e.which) ? e.which : event.keyCode

            if (charCode != 43 && charCode > 31 && (charCode < 48 || charCode > 57))

                return false;

            return true;
        });
    });

    function resetForm() {

        document.getElementById("contact_form").reset();

    }

</script>

@endsection

