$(document).ready(function () {

    $.validator.addMethod("regexpress",
            function (value, element, regexp) {
                var re = new RegExp(regexp);
                return this.optional(element) || re.test(value);
            },
            "Invalid input"
            );

    $("#updateadmin").validate({
        rules: {
            firstname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            lastname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            phone: {
                required: true
            },
            address: {
                required: true
            }
        },
        messages: {
            firstname: {
                required: "Please enter first name",
                regexpress: "Please enter alphabets only"
            },
            lastname: {
                required: "Please enter last name",
                regexpress: "Please enter alphabets only"
            },
            phone: "Please enter Phone",
            address: "Please enter address"
        }
    });
    $("#adduser").validate({
        rules: {
            firstname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            lastname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            email:
                    {
                        required: true,
                        email: true
                    },
            phone: {
                required: true
                        //integer : true
            },
            user_status: {
                required: true
            },
            address: {
                required: true
            }
        },
        messages: {
            firstname: {
                required: "Please enter first name",
                regexpress: "Please enter alphabets only"
            },
            lastname: {
                required: "Please enter last name",
                regexpress: "Please enter alphabets only"
            },
            email: "Please enter Valid Email",
            phone: "Please enter Phone",
            user_status: "Please select user type",
            address: "Please enter address"
        }
    });


    $("#updateadminuser").validate({
        rules: {
            firstname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            lastname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            email:
                    {
                        required: true,
                        email: true
                    }
        },
        messages: {
            firstname: {
                required: "Please enter first name",
                regexpress: "Please enter alphabets only"
            },
            lastname: {
                required: "Please enter last name",
                regexpress: "Please enter alphabets only"
            },
            email: "Please enter Valid Email"

        }
    });
    //icheck admin settings - Add
    $("#addsettings").validate({
        rules: {
            cpc: {
                required: true,
                number: true
            },
            paypal_id: {
                required: true,
                regexpress: /^[a-zA-Z0-9]+$/
            },
            cashout_min_points: {
                required: true,
                number: true
            },
            cash_out_fee: {
                required: true,
                number: true
            },
            max_cash_out: {
                required: true,
                number: true
            }
        },
        messages: {
            cpc: {
                required: "Please enter cpc",
                number: "Please enter numbers only"
            },
            paypal_id: {
                required: "Please enter paypal_id",
                regexpress: "Please enter alphabets and numbers only"
            },
            cashout_min_points: {
                required: "Please enter cashout minimum points",
                number: "Please enter numbers only"
            },
            cash_out_fee: {
                required: "Please enter cash-out fee",
                number: "Please enter numbers only"
            },
            max_cash_out: {
                required: "Please enter maximum cash-out",
                number: "Please enter numbers only"
            }
        }
    });

    //icheck admin settings - Edit
    $("#editsettings").validate({
        rules: {
            cpc: {
                required: true,
                number: true
            },
            paypal_id: {
                required: true,
                regexpress: /^[a-zA-Z0-9]+$/
            },
            cashout_min_points: {
                required: true,
                number: true
            },
            cash_out_fee: {
                required: true,
                number: true
            },
            max_cash_out: {
                required: true,
                number: true
            }
        },
        messages: {
            cpc: {
                required: "Please enter cpc",
                number: "Please enter numbers only"
            },
            paypal_id: {
                required: "Please enter paypal_id",
                regexpress: "Please enter alphabets and numbers only"
            },
            cashout_min_points: {
                required: "Please enter cashout minimum points",
                number: "Please enter numbers only"
            },
            cash_out_fee: {
                required: "Please enter cash-out fee",
                number: "Please enter numbers only"
            },
            max_cash_out: {
                required: "Please enter maximum cash-out",
                number: "Please enter numbers only"
            }
        }
    });
    //icheck points settings - Edit
    $("#update").validate({
        rules: {
            activity_points: {
                required: true,
                number: true
            }
        },
        messages: {
            activity_points: {
                required: "Please enter activity points",
                number: "Please enter numbers only"
            }
        }
    });
    //reviews-edit
    $("#updateuser").validate({
        rules: {
            review: {
                required: true
            }
        },
        messages: {
            review: "Please enter review message"
        }
    });
    //Reported reviews-edit
    $("#updatereport").validate({
        rules: {
            review: {
                required: true
            }
        },
        messages: {
            review: "Please enter review message"
        }
    });
    //add business
    $("#merchanstexcel_form").validate({
        rules: {
            excel_file: {
                required: true
            }
        },
        messages: {
            excel_file: "Please upload excel sheet"
        }
    });

    $("#addendmerchant").validate({
        rules: {
            firstname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            lastname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            email:
                    {
                        required: true,
                        email: true
                    },
            password: {
                required: true
                        //integer : true
            },
            location: {
                required: true
            }
        },
        messages: {
            firstname: {
                required: "Please enter first name",
                regexpress: "Please enter alphabets only"
            },
            lastname: {
                required: "Please enter last name",
                regexpress: "Please enter alphabets only"
            },
            email: "Please enter Valid Email",
            password: "Please enter Password",
            location: "Please enter Location"
        }
    });

    //icheck admin settings-categories - Edit
    $("#addcat").validate({
        rules: {
            catname: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            },
            status: {
                required: true
            }

        },
        messages: {
            catname: {
                required: "Please enter category name",
                regexpress: "Please enter alphabets only"
            },
            status: {
                required: "Please select status"
            }
        }
    });
    //icheck admin settings-categories - Edit
    $("#editcat").validate({
        rules: {
            name: {
                required: true,
                regexpress: /^[a-zA-Z ]+$/
            }

        },
        messages: {
            name: {
                required: "Please enter category name",
                regexpress: "Please enter alphabets only"
            }
        }
    });
$("#merchanstexcel_form1").validate({
        rules: {
            excel_file: {
                required: true
            }
        },
        messages: {
            excel_file: "Please upload excel sheet"
        }
    });
});//ready

