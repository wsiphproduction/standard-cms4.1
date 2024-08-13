@extends('theme.main')



@section('pagecss')

<style>
    .dentist-button {
        display: flex;
        flex-wrap: wrap;
        justify-content: right;
    }
</style>

@endsection



@section('content')

<div class="container topmargin-lg bottommargin-lg">
    <div class="row">
        <div class="col-12" id="searchLabel">
            
            {!! $page->contents !!}
    
            <div class="alert alert-success" style="display:none;" id="success_notif">
                <i class="icon-gift"></i><strong>Dentist Found!</strong>.
            </div>
            
            <div class="alert alert-danger" style="display:none;" id="failed_notif">
                <i class="icon-remove-sign"></i><strong>No Dentist Found!</strong> Change a few things up and try submitting again.
            </div>
            
            <div class="dentist-result mb-5 table-responsive" style="display:none;" id="dentist_result">
                <table class="table table-hover table-bordered" id="dentist-result-table">
                    <thead>
                        <tr>
                            <th>Clinic Name</th>
                            <th>Dentist</th>
                            <th>Clinic Address</th>
                            <th>Contact Number</th>
                        </tr>
                    </thead>
                    <tbody id="dentist-result-table-body">
                 
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <img src="images/misc/image6.jpg" />
        </div>

        <!-- Find Dentist Form -->
        <div class="col-md-6">
            <form class="row mb-0" method="get" id="form-dentist">
                <div class="form-process">
                    <div class="css3-spinner">
                        <div class="css3-spinner-scaler"></div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row">
                        <div class="col-sm-3 col-form-label">
                            <label for="">Region:</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-select required" name="select-region" id="select-region" onchange="setProvince(this.value)">
                                <option value="" name="" selected disabled>Choose...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row">
                        <div class="col-sm-3 col-form-label">
                            <label for="">Province:</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-select required" name="select-province" id="select-province" onchange="setCity(this.value)">
                                <option value="" selected disabled>Choose...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row">
                        <div class="col-sm-3 col-form-label">
                            <label for="">City:</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-select required" name="select-city" id="select-city">
                                <option value="" selected disabled>Choose...</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row">
                        <div class="col-sm-3 col-form-label">
                            <label for="">Dentist Last Name:</label>
                        </div>
                        <div class="col-sm-9">
                            <input type="text" name="last-name" id="last-name" class="form-control required" value="" placeholder="Enter Last Name">
                        </div>
                    </div>
                </div>
                <div class="col-12 form-group">
                    <div class="row">
                        <div class="col-sm-3 col-form-label">
                            <label for="">Specialization:</label>
                        </div>
                        <div class="col-sm-9">
                            <select class="form-select required" name="checkout-form-shipping-country" id="specialization">
                                <option value="" selected disabled>Choose...</option>
                                @forelse($dentistSpecialties as $specialty)
                                    <option value="{{ $specialty }}">{{  $specialty }}</option>
                                    @empty
                                    <option value="No Data">No Data</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="dentist-button">
                    <button type="submit" class="btn btn-success ms-2">Search</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('pagejs')

<script>
     var app_url = "{{ env('APP_URL') }}";

    $(document).ready(function() {
        loadRegion();

        $("#form-dentist").submit(function(e) {

            e.preventDefault();

            document.getElementById('dentist_result').style.display = "none"
            document.getElementById('failed_notif').style.display = "none";

            let params = {
                region : document.getElementById("select-region").selectedOptions[0].name ? document.getElementById("select-region").selectedOptions[0].name  :  "",
                province : document.getElementById("select-province").selectedOptions[0].name ? document.getElementById("select-province").selectedOptions[0].name  :  "",
                city : document.getElementById("select-city").selectedOptions[0].name ? document.getElementById("select-city").selectedOptions[0].name  :  "",
                last_name : document.getElementById("last-name").value,
                specialization : document.getElementById("specialization").value,
            }

            $.ajax({
                type: "POST",
                url: app_url + '/search-dentist',
                data: params,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {

                    var table = document.getElementById('dentist-result-table');

                    $("#dentist-result-table-body tr").remove();
                    //alert(validateRequest())
                    if(validateRequest() && response.data.length) {
                        response.data.forEach(function (dentist, index) {
                        
                            var row = table.getElementsByTagName('tbody')[0].insertRow();

                            var cell1 = row.insertCell(0);
                            var cell2 = row.insertCell(1);
                            var cell3 = row.insertCell(2);
                            var cell4 = row.insertCell(3);

                            cell1.innerHTML = dentist.clinic_name;
                            cell2.innerHTML = "Dr." + dentist.first_name  + " " + dentist.last_name;
                            cell3.innerHTML = dentist.full_address;
                            cell4.innerHTML = dentist.contact_number;
                            })

                            document.getElementById('success_notif').style.display = "block";
                            document.getElementById('dentist_result').style.display = "block"
                        } else {
                            document.getElementById('success_notif').style.display = "none";
                            document.getElementById('dentist_result').style.display = "none"
                            document.getElementById('failed_notif').style.display = "block";
                        }
                
                        //Scroll to results
                        var container = document.body,
                        element = document.getElementById('searchLabel').scrollIntoView();
                        container.scrollTop = element.offsetTop;
        
                },
                // error: function () {
                //     console.log("Error occurred");
                // }
            });
        });
    })

    function validateRequest() {
        if(document.getElementById("select-region").selectedOptions[0].name != null) { return true }
        else if(document.getElementById("select-province").selectedOptions[0].name != null) { return true }
        else if(document.getElementById("select-city").selectedOptions[0].name != null) { return true }
        else if(document.getElementById("last-name").value) { return true }
        else if(document.getElementById("specialization").value) { return true} 
        else { return false }
    }

    async function loadRegion(){
        const response = await fetch("https://psgc.cloud/api/regions");
        const regions = await response.json();

        regions.forEach((region) => {
            var x = document.getElementById("select-region");
            var option = document.createElement("option");
            option.text = region.name;
            option.name = region.name;
            option.value = region.code;
            x.add(option);
        })
    }

    async function setProvince(region) {
        reset();

        if(region == "1300000000") { // NCR REGION
            setCity(region);
        } else {
            region = document.getElementById("select-region").value;
            
            const response = await fetch(`https://psgc.cloud/api/regions/${region}/provinces`);
            const provinces = await response.json();


            provinces.forEach((province) => {
                let x = document.getElementById("select-province");
                let option = document.createElement("option");
                option.text = province.name;
                option.name = province.name;
                option.value = province.code;
                x.add(option);
            })
        }
    }

    async function setCity(province) {
        let url = `https://psgc.cloud/api/provinces/${province}/cities-municipalities`;
        if(province == "1300000000") { // NCR
            url = `https://psgc.cloud/api/regions/${province}/cities-municipalities`
        }

        const response = await fetch(url);
        const cities = await response.json();

        cities.forEach((city) => {
            var x = document.getElementById("select-city");
            var option = document.createElement("option");
            option.text = city.name;
            option.name = city.name;
            option.value = city.code;
            x.add(option);
        })
    }

    async function reset() {
        document.getElementById("select-province").innerHTML = "";
        let select_province = document.getElementById("select-province");
        let option = document.createElement("option");
        option.text = "Choose..";
        option.name = "";
        option.value = "";
        select_province.add(option);

        document.getElementById("select-city").innerHTML = "";
        let select_city = document.getElementById("select-city");
        let option_city = document.createElement("option");
        option_city.text = "Choose..";
        option_city.name = "";
        option_city.value = "";

        select_city.add(option_city);
    }
</script>

@endsection

