<?php if ( ! defined( 'ABSPATH' ) ) exit;
global $wp_locale;

$date_format = Ninja_Forms()->get_setting( 'date_format' );
if( ! $date_format ) $date_format = get_option( 'date_format' );

return apply_filters( 'ninja_forms_i18n_front_end', array(

    'ninjaForms'                            => __( 'Ninja Forms', 'ninja-forms' ),
    'changeEmailErrorMsg'                   => __( 'Please enter a valid email address!', 'ninja-forms' ),
    'confirmFieldErrorMsg'                  => __( 'These fields must match!', 'ninja-forms' ),
    'fieldNumberNumMinError'                => __( 'Number Min Error', 'ninja-forms' ),
    'fieldNumberNumMaxError'                => __( 'Number Max Error', 'ninja-forms' ),
    'fieldNumberIncrementBy'                => __( 'Please increment by ', 'ninja-forms' ),
    'fieldTextareaRTEInsertLink'            => __( 'Insert Link', 'ninja-forms' ),
    'fieldTextareaRTEInsertMedia'           => __( 'Insert Media', 'ninja-forms' ),
    'fieldTextareaRTESelectAFile'           => __( 'Select a file', 'ninja-forms' ),
    'formErrorsCorrectErrors'               => __( 'Please correct errors before submitting this form.', 'ninja-forms' ),
    'validateRequiredField'                 => __( 'This is a required field.', 'ninja-forms' ),
    'honeypotHoneypotError'                 => __( 'Honeypot Error', 'ninja-forms' ),
    'fileUploadOldCodeFileUploadInProgress' => __( 'File Upload in Progress.', 'ninja-forms' ),
    'fileUploadOldCodeFileUpload'           => __( 'FILE UPLOAD', 'ninja-forms' ),
    'currencySymbol'                        => Ninja_Forms()->get_setting( 'currency_symbol' ),
    'fieldsMarkedRequired'                  => sprintf( __( 'Fields marked with an %s*%s are required', 'ninja-forms' ), '<span class="ninja-forms-req-symbol">', '</span>' ),
    'thousands_sep'                         => $wp_locale->number_format[ 'thousands_sep' ],
    'decimal_point'                         => $wp_locale->number_format[ 'decimal_point' ],
    'dateFormat'                            => $date_format,
    'startOfWeek'                           => get_option( 'start_of_week' ),
    'of'                                    => __( 'of', 'ninja-forms' ),
    'previousMonth'                         => __( 'Previous Month', 'ninja-forms' ),
    'nextMonth'                             => __( 'Next Month', 'ninja-forms' ),
    'months'                                => array(
                                                __( 'January', 'ninja-forms' ),
                                                __( 'February', 'ninja-forms' ),
                                                __( 'March', 'ninja-forms' ),
                                                __( 'April', 'ninja-forms' ),
                                                __( 'May', 'ninja-forms' ),
                                                __( 'June', 'ninja-forms' ),
                                                __( 'July', 'ninja-forms' ),
                                                __( 'August', 'ninja-forms' ),
                                                __( 'September', 'ninja-forms' ),
                                                __( 'October', 'ninja-forms' ),
                                                __( 'November', 'ninja-forms' ),
                                                __( 'December', 'ninja-forms' )
                                            ),
    'monthsShort'                           => array(
                                                __( 'Jan', 'ninja-forms' ),
                                                __( 'Feb', 'ninja-forms' ),
                                                __( 'Mar', 'ninja-forms' ),
                                                __( 'Apr', 'ninja-forms' ),
                                                __( 'May', 'ninja-forms' ),
                                                __( 'Jun', 'ninja-forms' ),
                                                __( 'Jul', 'ninja-forms' ),
                                                __( 'Aug', 'ninja-forms' ),
                                                __( 'Sep', 'ninja-forms' ),
                                                __( 'Oct', 'ninja-forms' ),
                                                __( 'Nov', 'ninja-forms' ),
                                                __( 'Dec', 'ninja-forms' ),
                                            ),
    'weekdays'                              => array(
                                                __( 'Sunday', 'ninja-forms' ),
                                                __( 'Monday', 'ninja-forms' ),
                                                __( 'Tuesday', 'ninja-forms' ),
                                                __( 'Wednesday', 'ninja-forms' ),
                                                __( 'Thursday', 'ninja-forms' ),
                                                __( 'Friday', 'ninja-forms' ),
                                                __( 'Saturday', 'ninja-forms' ),
                                            ),
    'weekdaysShort'                         => array(
                                                __( 'Sun', 'ninja-forms' ),
                                                __( 'Mon', 'ninja-forms' ),
                                                __( 'Tue', 'ninja-forms' ),
                                                __( 'Wed', 'ninja-forms' ),
                                                __( 'Thu', 'ninja-forms' ),
                                                __( 'Fri', 'ninja-forms' ),
                                                __( 'Sat', 'ninja-forms' ),
                                            ),
    'weekdaysMin'                           => array(
                                                __( 'Su', 'ninja-forms' ),
                                                __( 'Mo', 'ninja-forms' ),
                                                __( 'Tu', 'ninja-forms' ),
                                                __( 'We', 'ninja-forms' ),
                                                __( 'Th', 'ninja-forms' ),
                                                __( 'Fr', 'ninja-forms' ),
                                                __( 'Sa', 'ninja-forms' )
                                            )
));
