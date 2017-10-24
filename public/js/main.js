$(document).ready(function () {

    jQuery(function($){
        $("#form-telephone").mask("(999)999-99-99");
    });

if(isDeploy){
    VK.init(function () {

        setInterval(newSizeWindow, 100);
        function newSizeWindow() {
            VK.callMethod("resizeWindow", 700, $('.main-container').height());
        }

        var city;
        VK.api("users.get", {"fields": "city,education,bdate"}, function (data) {

            $("#hiddenID").attr("value", data.response[0].uid);
            $("#form-nickname").attr("value", data.response[0].first_name);
            $("#hiddenSurname").attr("value", data.response[0].last_name);
            $("#bdate").attr("value", data.response[0].bdate);
            $("#university_name").attr("value", data.response[0].university_name);
            $("#faculty_name").attr("value", data.response[0].faculty_name);
            city = data.response[0].city;


            VK.api("database.getCitiesById", {"city_ids": city}, function (data) {

                $("#city").attr("value", data.response[0].name);
            });
        });


    });
}

    //TAB
    $(".menu-description").click(function () {

        $(this).css("background-color","#485c7f");
        $(".tickets-list, .menu-photo").css("background-color","inherit");

        $(".tickets-list-wrapper").css("display", "none");
        $(".description-wrapper").css("display", "block");
        $(".photo-wrapper").css("display", "none");
    });

    $(".tickets-list").click(function () {

        $(this).css("background-color","#485c7f");
        $(".menu-photo, .menu-description").css("background-color","inherit");


        $(".tickets-list-wrapper").css("display", "block");
        $(".description-wrapper").css("display", "none");
        $(".photo-wrapper").css("display", "none");


    });
    $(".menu-photo").click(function () {

        $(this).css("background-color","#485c7f");
        $(".tickets-list, .menu-description").css("background-color","inherit");


        $(".photo-wrapper").css("display", "block");
        $(".description-wrapper").css("display", "none");
        $(".tickets-list-wrapper").css("display", "none");
    });


    //Total Payment
    function getFirstCountElementInObj(obj) {
        for (var count in obj) {
            return count;
            break;
        }
    }


    $(".count-peoples-add").on("click", function () {
        var peoples = +$(".count-peoples-summ").text();
        if (peoples < maxPeople) {
            $(".count-peoples-summ").html(function () {
                var number = +$(this).text();

                return number + 1;
            });
        }


    });

    $(".count-peoples-reduce").on("click", function () {
        var peoples = +$(".count-peoples-summ").text();
        if (peoples > minPeople) {
            $(".count-peoples-summ").html(function () {
                var number = +$(this).text();

                return number - 1;
            });
        }
    });


    var value = parseInt($(".pricevalue").html());
/////////////////////////////////
    var servicePrice = 0;
    if (dataPeoplesObject.length !== 0) {

        // var value = parseInt($(".pricevalue").html());
        var objPrices = {};
        var lastPrice = value;
        var peoples = +$(".count-peoples-summ").text();

        for (var i = minPeople; i <= maxPeople; i++) {
            var count = i;
            for (var key in dataPeoplesObject) {
                if (count === dataPeoplesObject[key]['count_peoples']) {
                    objPrices[count] = dataPeoplesObject[key]['price'];
                    objPrices[count] += value;
                    lastPrice = objPrices[count];
                    break;
                } else {
                    objPrices[count] = lastPrice;
                }
            }
        }

//       else other type
        var prices = {};
        var countPrice;
        var pr = 0;
        for (var count in objPrices) {
            if (objPrices[count] !== value) {
                for (var key in dataPeoplesObject) {
                    if (dataPeoplesObject[key]['count_peoples'] === +count) {
                        countPrice = dataPeoplesObject[key]['price'];
                    }
                }
                pr += countPrice;
                prices[count] = pr;
            }

        }

        var objOtherPrice = {};
        var firstCount = +getFirstCountElementInObj(prices);
        for (var count in objPrices) {
            objOtherPrice[count] = value + prices[count];
        }

        for (var count in objOtherPrice) {

            if (+count === firstCount) {
                break;
            }
            objOtherPrice[count] = value;
        }


// endelse


        var totalPrice;
        $(".count-peoples-add, .count-peoples-reduce").click(function () {
            if (dataPeoplesObject.length !== 0) {

                peoples = +$(".count-peoples-summ").text();

                $(".pricevalue").html(function () {
                    if (calculationPriceType) {
                        totalPrice = servicePrice + objOtherPrice[peoples];

                    } else {
                        totalPrice = servicePrice + objPrices[peoples];
                    }

                    if (value !== parseInt($(".pricevalue").html())) {
                        $(".pricevalue").animate({fontSize: 30}, 1000);
                    }

                    return ' ' + totalPrice;
                });
            }
        });
////////////////////////////////////////////

    }


    $(":checkbox").click(function () {
        price = $(this).attr('value');
        var totalPrice;
        if ($(this).prop('checked')) {
            servicePrice += parseInt(price);
            $(".pricevalue").html(function (i, numb) {
                totalPrice = parseInt(numb) + parseInt(price);
                return ' ' + totalPrice;
            }).animate({fontSize: 30}, 1000);
        } else {
            servicePrice -= parseInt(price);
            $(".pricevalue").html(function (i, numb) {
                totalPrice = parseInt(numb) - parseInt(price);
                return ' ' + totalPrice;
            });
        }


    });
//FORM VALIDATION


    $("input[type=text]").on("keyup", function () {
        console.log($("#form-telephone").val().length);
        $(".error-message").remove();
        if ($("#form-nickname").val().length !== 0 && $("#form-telephone").val().length !== 0) {
            $(".button-reserve")
                .removeClass("button-disabled")
                .animate({opacity: 1}, 500)
                .removeAttr('disabled');
        } else {
            $(".button-reserve")
                .addClass("button-disabled")
                .animate({
                    opacity: 0.7,
                    background: "#a5a5a5"
                }, 500)
                .attr("disabled", 'true');
        }
    });



    //functions for validations
    function isNumeric(n) {
        return !isNaN(parseFloat(n)) && isFinite(n);
    }

    function validName(name) {
        var errors;
        if (name.length === 0) {
            errors = 1;
        } else if (name.length > 30) {
            errors = 2;
        }
        if (errors !== undefined) {
            return errors;
        } else {
            return true;
        }

    }

    function validPhone(phone) {
        var errors;
        if (phone.length === 0) {
            errors = 1;
        } else if (phone.length > 14) {
            errors = 2;
        }

        if (errors !== undefined) {
            return errors;
        } else {
            return true;
        }

    }


// Ajax
    $(".button-reserve").click(function () {


        //validation test
        var errorName = validName($("#form-nickname").val());
        var errorPhone = validPhone($("#form-telephone").val());

        if (errorName === 1) {
            textError = "<div class='error-message'>Пустое поле</div>";
            $("#form-nickname").prepend(textError);
        } else if (errorName === 2) {
            textError = "<div class='error-message'>Слишком длинное имя</div>";
            $(".name").prepend(textError);
        } else if (errorPhone === 1) {
            textError = "<div class='error-message'>Пустое поле</div>";
            $(".telephone").prepend(textError);
        } else if (errorPhone === 2) {
            textError = "<div class='error-message'>Слишком длинный номер</div>";
            $(".telephone").prepend(textError);
        } else if (errorPhone === 3) {
            textError = "<div class='error-message'>Номер должен состоять из чисел</div>";
            $(".telephone").prepend(textError);
        } else {

            //Object formation for POST

            var inputs = $('.form-reserve').find('input[type=text],input[type=hidden],:checked'),
                object = {},
                prices;

            if (dataPeoplesObject.length === 0) {
                var staticPrices = {};

                peoples = +$(".count-peoples-summ").text();

                for (var i = 1; i <= maxPeople; i++) {
                    staticPrices[i] = value;
                }
                $.each(inputs, function (num, element) {
                    object[$(element).attr('name')] = $(element).val()
                });

                object.countPeoples = peoples;
                object.dataPrices = $.toJSON(staticPrices);

            } else {
                object.countPeoples = peoples;

                $.each(inputs, function (num, element) {
                    object[$(element).attr('name')] = $(element).val()
                });
                if (calculationPriceType) {
                    prices = $.toJSON(objOtherPrice);

                } else {
                    prices = $.toJSON(objPrices);
                }

                object.dataPrices = prices;
            }

            console.log(object);


            //AJAX SEND

            $.ajax({
                type: "POST",
                url: window.location.href,
                data: object,
                cache: false,
                success: function (data) {
                    $(".section-userdata").css("display", "none");
                    $(".button-reserve").css("display", "none");
                    $(".reserve-successful").css("display", "block");
                    $(".count-peoples-control").css("display", "none");
                    $(".section-services-one").css("margin-left","230px");
                    $(".section-services-two").css("display","none");
                    $(":checkbox").unbind();

                }
            });


        }


    });


});

