"use strict";

class FormValidate {

    constructor($form)
    {
        this.$form = $form;
        this.$errorMessage = this.$form.find('.error-message');
        this.errors = [];

        this.$form.submit(this.checkFields.bind(this));
    }

    checkRequired()
    {
        // Retrieve data required
        const htmlElement = this.$form.find('[data-required]');

        for(let index = 0; index < htmlElement.length; index++){
            let input = htmlElement[index];


            // If require fields are empty, prevent default and display errors
            if(input.value.length === 0){
                this.errors.push("The field "+ input.dataset.name +" is required.");
            }
        }
    }

    checkMinLength()
    {
        // Retrieve data minimum length
        const htmlElement = this.$form.find('[data-minlength]');

        for(let index = 0; index < htmlElement.length; index++){
            let input = htmlElement[index];
            let minLength = input.dataset.minlength;

            // If require fields are empty, prevent default and display errors
            if(input.value.length > 0 && input.value.length < minLength){
                this.errors.push("Field "+ input.dataset.name +" must be at least "+ minLength +" long.");
            }
        }
    }

    checkMaxLength()
    {
        // Retrieve data max-length
        const htmlElement = this.$form.find('[data-maxlength]');

        for(let index = 0; index < htmlElement.length; index++){
            let input = htmlElement[index];
            let maxLength = input.dataset.maxlength;

            // If require fields are empty, prevent default and display errors
            if(input.value.length > 0 && input.value.length > maxLength){
                this.errors.push("The field "+ input.dataset.name +" must be maximum "+ maxLength + " long.");
            }
        }
    }

    checkType()
    {
        // Retrieve data type
        const htmlElement = this.$form.find('[data-type]');

        for(let index = 0; index < htmlElement.length; index++) {
            let input = htmlElement[index];
            let type = input.dataset.type;
            let value = input.value;

            if (input.value.length === 0){
                continue;
            }

            switch(type){

                case "string":
                    // Allowed caracthers A-Z, a-Z, space and dash
                    if(!value.match(/^[A-Za-z\s\-]+$/)){
                        this.errors.push("The field "+ input.dataset.name +" must be all letters");

                    }
                    break;

                case "email":
                    if(!value.match(/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/)){
                        this.errors.push("Field "+ input.dataset.name +" is not a valid email format");
                    }
                    break;

                case "password":
                    if(!value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*[\d])(?=.*[\-.$@!%*?&\s#])[\w\s\-.$@!%*?&#]*/))
                        this.errors.push('The field '+ input.dataset.name +' must have at least one capital letter, one small letter, a number and a special character.' );
                    break;
            }
        }
    }

    checkFields(event)
    {

        // Check rules
        this.checkRequired();
        this.checkMinLength();
        this.checkMaxLength();
        this.checkType();

        if(this.errors.length > 0){
            // Manage errors
            event.preventDefault();
            this.displayErrors();
        }
    }

    displayErrors(){

        let ul = $('<ul>');


        for (let index = 0; index < this.errors.length; index++) {
            ul.append(
                $('<li>').text(this.errors[index])
            );
        }

        // Display errors
        this.$errorMessage.html(ul).fadeIn();


        // Once done display diffault
        this.errors = [];

        // scroll vers les messages d'erreurs
        window.scrollTo(0,0);
    }

}





















