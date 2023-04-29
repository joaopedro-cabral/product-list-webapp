// <------------------ FUNCTIONS ------------------>
function getProducts()
{
    $.ajax({
        type: 'GET',
        url: 'api/ajax.php',
        dataType: 'json',
        encode: true
    }).done(function( response ){
        response = JSON.stringify( response );

        var html = "";

        if( response.length > 2 ){
            $.each(JSON.parse( response ), function( key, value ){
                html += '<div class="col-md-3 my-4">';
                html += '<div id="product-item" class="card border-0 shadow h-100" >';
                html += '<div class="card-header d-flex flex-row align-items-center">';
                html += '<div class="form-check">';
                html += '<input class="delete-checkbox form-check-input" type="checkbox" value="'+value.sku+'" id="flexCheckDefault">';
                html += '</div>';
                html += '<h6>'+value.sku+'</h6>';
                html += '</div>';
                html += '<div class="card-body d-flex flex-column align-items-start">';
                html += '<h5 class="card-title">'+value.name+'</h5>';
                html += '<p>'+value.attribute+'</p>';
                html += '</div>';
                html += '<div class="card-body d-flex align-items-end">';    
                html += '<p class="text-success h5">'+value.price+' $</p>';
                html += '</div>';
                html += '</div>';                                
                html += '</div>';
            });
        } else {
            html += '<div class="alert alert-warning">';
            html += 'No records found! Try to add a product to the list.';
            html += '</div>';
        }

        $( '#product-list' ).html( html );
    }).fail( function () {
        Swal.fire({
            icon: 'error',
            title: 'Fatal Error...',
            text: 'Could not reach server! Try again!',
          }).then((result) => {
            // refreshs page
            window.location.reload(true);
        }); 
    });
}

function addProduct(formData)
{
    $.ajax({
        type: 'POST',
        url: 'api/ajax.php',
        data: {
            action: 'insert',
            data: formData,
        },
        dataType: 'json',
        encode: true,
    }).done( function ( data ) {
        if ( !data.success ) {
            var fields = [
                { id: 'sku', group: 'sku_group', errorClass: 'border-danger', successClass: 'border-success' },
                { id: 'name', group: 'name_group', errorClass: 'border-danger', successClass: 'border-success' },
                { id: 'price', group: 'price_group', errorClass: 'border-danger', successClass: 'border-success' },
            ];
            
            // adds specific notification messages for all input fields
            for ( var i = 0; i < fields.length; i++ ) {
                var field = fields[i];
                var $elem = $( '#' + field.id );
                var $group = $( '#' + field.group );
            
                if ( data.errors[ field.id ] ) {
                    $elem.removeClass( field.successClass );
                    $elem.addClass( field.errorClass );
                    $group.addClass( 'has-error' );
                    $group.append( '<div class="help-block text-danger my-2">' + data.errors[ field.id ] + '</div>' );
                } else {
                    $elem.removeClass( field.errorClass );
                    $elem.addClass( field.successClass );
                    $group.removeClass( 'has-error' );
                    $group.find( '.help-block' ).remove();
                }
            }         

            if ( data.errors.type ) {
                $( '#productType' ).addClass( 'border-danger' );
                $( '#type_group' ).addClass( 'has-error' );
                $( '#type_group' ).append(
                    '<div class="help-block text-danger my-2">' + data.errors.type + '</div>'
                );
            } else {
                $( '#productType' ).removeClass( 'border-danger' );
                $( '#productType' ).addClass( 'border-success' );

                if ( data.errors.size ) {
                    $( '#size' ).addClass( 'border-danger' );
                    $( '#productSizeField' ).addClass( 'has-error' );
                    $( '#productSizeField' ).append(
                        '<div class="help-block text-danger my-2">' + data.errors.size + '</div>'
                    );
                } else {
                    $( '#size' ).removeClass( 'border-danger' );
                    $( '#size' ).addClass( 'border-success' );
                }

                if ( data.errors.weight ) {
                    $( '#weight').addClass( 'border-danger' );
                    $( '#productWeightField' ).addClass( 'has-error' );
                    $( '#productWeightField' ).append(
                        '<div class="help-block text-danger my-2">' + data.errors.weight + '</div>'
                    );
                } else {
                    $( '#weight' ).removeClass( 'border-danger' );
                    $( '#weight' ).addClass( 'border-success' );
                }

                if ( data.errors.measures ) {
                    if ( data.errors.height ) {
                        $( '#height' ).addClass( 'border-danger' );
                    } else {
                        $( '#height' ).removeClass( 'border-danger' );
                        $( '#height' ).addClass( 'border-success' );
                    }

                    if ( data.errors.width ) {
                        $( '#width' ).addClass( 'border-danger' );
                    } else {
                        $( '#width' ).removeClass( 'border-danger' );
                        $( '#width' ).addClass( 'border-success' );
                    }

                    if ( data.errors.length ) {
                        $( '#length' ).addClass( 'border-danger' );
                    } else {
                        $( '#length' ).removeClass( 'border-danger' );
                        $( '#length' ).addClass( 'border-success' );
                    }

                    $( '#productMeasuresField' ).addClass( 'has-error' );
                    $( '#productMeasuresField' ).append(
                        '<div class="help-block text-danger my-2">' + data.errors.measures + '</div>'
                    );
                } else {
                    $( '#height' ).removeClass( 'border-danger' );
                    $( '#height' ).addClass( 'border-success' );
                    $( '#width' ).removeClass( 'border-danger' );
                    $( '#width' ).addClass( 'border-success' );
                    $( '#length' ).removeClass( 'border-danger' );
                    $( '#length' ).addClass( 'border-success' );
                }
            }
        } else {
            // goes back to home
            window.location.replace("/");
        }

    }).fail(function () {
        Swal.fire({
            icon: 'error',
            title: 'Fatal Error...',
            text: 'Could not reach server! Try again!',
          }).then((result) => {
            // refreshs page
            window.location.reload(true);
        }); 
    });
}

function deleteProducts( skuArr )
{
    $.ajax({
        type: 'POST',
        url: 'api/ajax.php',
        data: {
            action: 'delete',
            data: skuArr,
        },
        dataType: 'json',
        encode: true,
    }).done( function() { 
        // reloads product-list
        getProducts();

    }).fail( function() {
        Swal.fire({
            icon: 'error',
            title: 'Fatal Error...',
            text: 'Could not reach server! Try again!',
          }).then((result) => {
            // refreshs page
            window.location.reload(true);
        }); 
    });
}

// <------------------ EXECUTION ------------------>
// document ready
$( function() {
    // set page buttons where-to-go location
    $( 'button' ).on( 'click', ( function() {

        if ( $( this ).attr( "href" )) {
          window.location.href = $( this ).attr( "href" );
        }}
    ));

    // adds product
    $( '#product_form' ).on( 'submit', function( e ) {
        $( '.form-group' ).removeClass( 'has-error' );
        $( '.help-block' ).remove();

        e.preventDefault();

        var formData = {
            sku: $( '#sku' ).val(),
            name: $( '#name' ).val(),
            price: $( '#price' ).val(),
            type: $( '#productType' ).val(),
            size: $( '#size' ).val(),
            weight: $( '#weight' ).val(),
            height: $( '#height' ).val(),
            width: $( '#width' ).val(),
            length: $( '#length' ).val(),
        };

        addProduct( formData );
    });

    // deletes products
    $( '#delete-product-btn' ).on( 'click', function() {
        var productSkus = [];
        
        // get checked products to delete
        $( '.delete-checkbox' ).each( function(){
            if ($( this ).is( ':checked' )){
                var sku = $( this ).val();

                productSkus.push( sku )
            }
        })

        if( productSkus.length > 0 ){
            //destroys tooltip and clears its native browser message
            $("[data-toggle='tooltip']").tooltip('dispose');

            $('#delete-product-btn').attr('title', "");

            deleteProducts( productSkus );
        } else {
            //defines 'mass-delete' button tooltip message
            $('#delete-product-btn').attr('title', "There is no items selected for mass delete!");

            //shows tooltip
            $('[data-toggle="tooltip"]').tooltip('show');
        };
    });

    // changes type attribute visible at "add-product" based on selected combo option
    $( '#productType' ).on( 'change' , () => {  
        
        // split from selected what is type and what is attribute
        var selectedOptionVal = $( '#productType option:selected' ).val();
        var optionValues = selectedOptionVal.split( "|" );

        // makes selected option related input visible
        var selectedAttrId = '#product' + optionValues[ 1 ] + 'Field';
        
        $( selectedAttrId ).removeClass( 'd-none' );

        // stores not selected items
        var notSelected = $( '#productType option:not(:selected):not(:disabled)' );

        // sets the unselected options related fields not visible
        for ( var i = 0 ; i < notSelected.length ; i++ ){
            // split from not selected what is type and what is attribute
            var notSelectedVal = notSelected[i].value;
            var optionInv = notSelectedVal.split( "|" )

            // set not selected input id
            var notSelectedId = "#product" + optionInv[ 1 ] + 'Field';

            $( notSelectedId ).addClass( 'd-none' );
        }

    });

});

$( window ).on( "load", function() {
    
    $( '.preloader' ).remove();

});



