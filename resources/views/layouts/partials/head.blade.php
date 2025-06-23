<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--favicon-->
{{-- <link rel="icon" href="{{asset('assets')}}/images/eh/general-logo.png" type="image/png" /> --}}
<!--plugins-->
<link href="{{asset('assets')}}/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
<link href="{{asset('assets')}}/plugins/select2/css/select2.min.css" rel="stylesheet" />
<link href="{{asset('assets')}}/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
<link href="{{asset('assets')}}/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
<link href="{{asset('assets')}}/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
<!-- loader-->
<link href="{{asset('assets')}}/css/pace.min.css" rel="stylesheet" />
<script src="{{asset('assets')}}/js/pace.min.js"></script>
<!-- Bootstrap CSS -->
<link href="{{asset('assets')}}/css/bootstrap.min.css" rel="stylesheet">
<link href="{{asset('assets')}}/css/bootstrap-extended.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&amp;display=swap" rel="stylesheet">
<link href="{{asset('assets')}}/css/app.css" rel="stylesheet">
<link href="{{asset('assets')}}/css/icons.css" rel="stylesheet">
<!-- Theme Style CSS -->
<link rel="stylesheet" href="{{asset('assets')}}/css/dark-theme.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/semi-dark.css" />
<link rel="stylesheet" href="{{asset('assets')}}/css/header-colors.css" />
<link href="https://db.onlinewebfonts.com/c/d9bdd2ce056100415382dc8b2661c090?family=E%2BH+Serif" rel="stylesheet">
<link href="{{asset('assets')}}/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

<style>
    @font-face {
        font-family: 'digital-7regular';
        src: url('{{ asset('assets/fonts/digital/digital-7-webfont.woff2') }}') format('woff2'),
            url('{{ asset('assets/fonts/digital/digital-7-webfont.woff') }}') format('woff');
        font-weight: 300;
        font-style: normal;
    }

    @font-face {
        font-family: 'Poppins';
        src: url('{{ asset('assets/fonts/poppins/poppins-light-webfont.woff2') }}') format('woff2'),
            url('{{ asset('assets/fonts/poppins/poppins-light-webfont.woff') }}') format('woff');
        font-weight: normal;
        font-style: normal;
    }

    @font-face {
        font-family: 'eh_sansregular';
        src: url('{{ asset('assets/fonts/eh/eh_sansreg-webfont.woff2') }}') format('woff2'),
            url('{{ asset('assets/fonts/eh/eh_sansreg-webfont.woff') }}') format('woff');
        font-weight: normal;
        font-style: normal;
    }


    .tx-digital {
        font-family: "digital-7regular";
    }
    /* body {
        font-family: "E+H Serif", sans-serif;
    } */

    .text-color-eh {
        color: #009EE3;
    }

    .header-card-eh {
        background-color: #c9cfd5;
    }

    .tx-digital {
        font-family: "digital-7regular";
    }
    
</style>
@stack('css')