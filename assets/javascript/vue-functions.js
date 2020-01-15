
/*Used sitewide on the message section near the bottom.*/
var messageTextApp = new Vue({
    el: '.message',
    data: {
        messageText: "What's baking in the oven?",
        message1: "What's baking in the oven?",
        message2: "Coooookies!",
        showMessage: false,
        message: {
            backgroundColor: ""
        }
    },
    methods: {
        changeText: function (event) {
            console.log(event);
            this.showMessage = !this.showMessage;
            if (this.showMessage) {
                this.messageText = this.message2;
                this.message.backgroundColor = "#64460e";
            } else {
                this.messageText = this.message1;
                this.message.backgroundColor = "#ac8949";
            }
        }
    }
});
/*End of section.*/



/*Contact form live response, and client-side validation.*/
var contactUpdatedResponseApp = new Vue({
    el: '#contactContainer',
    data: {
        userFirstName: "",
        userLastName: "",
        userEmail: "",
        userComments: "",
        errors: [],
        clickedSubmit: false
    },
    methods: {
        validateForm: function (event) {
            this.errors = [];
            
            if (!this.userFirstName) {
                this.errors.push("Please enter a first name.");
                document.forms["contactOurBakery"]["userFirstName"].classList.add("required-field-needed");
            } else {
                document.forms["contactOurBakery"]["userFirstName"].classList.remove("required-field-needed");
            }
            
            if (!this.userLastName) {
                this.errors.push("Please enter a last name.");
                document.forms["contactOurBakery"]["userLastName"].classList.add("required-field-needed");
            } else {
                document.forms["contactOurBakery"]["userLastName"].classList.remove("required-field-needed");
            }

            var atPosition = this.userEmail.indexOf("@");
            var dotPosition = this.userEmail.lastIndexOf(".");
            var lastEmailCharacter = this.userEmail.length - 1;
            var validEmail = true;
            if (!this.userEmail) {
                validEmail = false;
            } else if (atPosition <= 0) {
                validEmail = false;
            } else if (atPosition + 1 >= dotPosition) {
                validEmail = false;
            } else if (dotPosition + 1 >= lastEmailCharacter) {
                validEmail = false;
            }
            if (validEmail === false) {
                this.errors.push("Please enter a valid email.");
                document.forms["contactOurBakery"]["userEmail"].classList.add("required-field-needed");
            } else {
                document.forms["contactOurBakery"]["userEmail"].classList.remove("required-field-needed");
            }

            if (!this.userComments) {
                this.errors.push("Please input your message.");
                document.forms["contactOurBakery"]["userComments"].classList.add("required-field-needed");
            } else {
                document.forms["contactOurBakery"]["userComments"].classList.remove("required-field-needed");
            }

            if(this.errors.length === 0){
                return true;
            } else {
                event.preventDefault();
                return false;
            }       
        },
        setClickedSubmitTrue: function (){
            this.clickedSubmit = true;
        }
    },
    computed: {       
        writeResponse: function () {
            var response = this.userFirstName + " " + this.userLastName;          
            if (this.clickedSubmit) {
                this.validateForm(event);
            }         
            return response;
        }
    }
});
/*End of section.*/



/*Estimate form live response and client-side validation.*/
var estimateUpdatedResponseApp = new Vue({
    el: '#estimateContainer',
    data: {
        userName: "",
        userEmail: "",
        userPhone: "",
        userStreetAddress: "",
        userCity: "",
        userState: "",
        userZipCode: "",
        additionalNotes: "",
        errors: [],
        clickedSubmit: false
    },
    methods: {
        validateForm: function (event) {
            this.errors = [];
            if (!this.userName) {
                this.errors.push("Please enter a name.");
                 document.forms["estimateForm"]["userName"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userName"].classList.remove("required-field-needed");
            }

            var atPosition = this.userEmail.indexOf("@");
            var dotPosition = this.userEmail.lastIndexOf(".");
            var lastEmailCharacter = this.userEmail.length - 1;
            var validEmail = true;
            if (!this.userEmail) {
                validEmail = false;
            } else if (atPosition <= 0) {
                validEmail = false;
            } else if (atPosition + 1 >= dotPosition) {
                validEmail = false;
            } else if (dotPosition + 1 >= lastEmailCharacter) {
                validEmail = false;
            }
            if (validEmail === false) {
                this.errors.push("Please enter a valid email.");
                document.forms["estimateForm"]["userEmail"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userEmail"].classList.remove("required-field-needed");
            }

            
            let validPhone = true;
            let userPhoneCheck = /^\d{10}$/;
            if (userPhoneCheck.test(this.userPhone) === false) {
                validPhone = false;
            }
            if (!this.userPhone || this.userPhone.length !== 10 || validPhone === false) {
                this.errors.push("Please enter phone number we can contact if needed.");
                document.forms["estimateForm"]["userPhone"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userPhone"].classList.remove("required-field-needed");
            }

            if (!this.userStreetAddress) {
                this.errors.push("Please enter the street address.");
                document.forms["estimateForm"]["userStreetAddress"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userStreetAddress"].classList.remove("required-field-needed");
            }       
            
            if (!this.userCity) {
                this.errors.push("Please provide the city.");
                document.forms["estimateForm"]["userCity"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userCity"].classList.remove("required-field-needed");
            }

            if (!this.userState) {
                this.errors.push("Please provide the state.");
                document.forms["estimateForm"]["userState"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userState"].classList.remove("required-field-needed");
            }

            let validZipCode = true;
            let userZipCodeCheck = /^\d{5}$/;
            if (userZipCodeCheck.test(this.userZipCode) === false) {
                validZipCode = false;
            }
            if (!this.userZipCode || this.userZipCode.length != 5 || validZipCode === false) {
                this.errors.push("Please provide the ZIP Code.");
                document.forms["estimateForm"]["userZipCode"].classList.add("required-field-needed");
            } else {
                document.forms["estimateForm"]["userZipCode"].classList.remove("required-field-needed");
            }

            
            if(this.errors.length === 0){
                return true;
            } else {
                event.preventDefault();
                return false;
            }
            
        },
        setClickedSubmitTrue: function (){
            this.clickedSubmit = true;
        }
    },
    computed: {
        writeResponse: function () {
            var response = this.userName;     
            if (this.clickedSubmit) {
                this.validateForm(event);
            }         
            return response;
        }
    }
});
/*End of section.*/



/*Careers form live response and client-side validation.*/
var careersUpdatedResponseApp = new Vue({
    el: '#careersContainer',
    data: {
        userName: "",
        userEmail: "",
        positionApplyingFor: "",
        userResume: "",
        errors: [],
        clickedSubmit: false
    },
    methods: {
        validateForm: function (event) {
            this.errors = [];
            if (!this.userName) {
                this.errors.push("Please enter a name.");
                document.forms["careersForm"]["userName"].classList.add("required-field-needed");
            } else {
                document.forms["careersForm"]["userName"].classList.remove("required-field-needed");
            }

            var atPosition = this.userEmail.indexOf("@");
            var dotPosition = this.userEmail.lastIndexOf(".");
            var lastEmailCharacter = this.userEmail.length - 1;
            var validEmail = true;
            if (!this.userEmail) {
                validEmail = false;
            } else if (atPosition <= 0) {
                validEmail = false;
            } else if (atPosition + 1 >= dotPosition) {
                validEmail = false;
            } else if (dotPosition + 1 >= lastEmailCharacter) {
                validEmail = false;
            }
            if (validEmail === false) {
                this.errors.push("Please enter a valid email.");
                document.forms["careersForm"]["userEmail"].classList.add("required-field-needed");
            } else {
                document.forms["careersForm"]["userEmail"].classList.remove("required-field-needed");
            }

            if (!this.positionApplyingFor) {
                this.errors.push("Please enter the position you are applying for.");
                document.forms["careersForm"]["positionApplyingFor"].classList.add("required-field-needed");
            } else {
                document.forms["careersForm"]["positionApplyingFor"].classList.remove("required-field-needed");
            }

            if (!this.userResume) {
                this.errors.push("Please copy and paste your resume in resume textarea.");
                document.forms["careersForm"]["userResume"].classList.add("required-field-needed");
            } else {
                document.forms["careersForm"]["userResume"].classList.remove("required-field-needed");
            }           
            
            if(this.errors.length === 0){
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        },
        setClickedSubmitTrue: function (){
            this.clickedSubmit = true;
        }
    },
    computed: {
        writeResponse: function () {
            var response = this.userName;     
            if (this.clickedSubmit) {
                this.validateForm(event);
            }         
            return response;
        }
    }
});
/*End of section.*/



/*Used sitewide in the footer: subscribe button/modal. */
Vue.component('modal', {
    template: '#modal-template'
});

var subscribeApp = new Vue({
    el: '.footer__subscribe',
    data: {
        showModal: false,
        userNameSubscribe: "",
        userEmailSubscribe: "",
        errors: [],
        clickedSubmit: false
    },
    methods: {
        validateSubscribeForm: function (event) {
            this.errors = [];
            if (!this.userNameSubscribe) {
                this.errors.push("Please enter a name.");
                document.forms["subscribeForm"]["userNameSubscribe"].classList.add("required-field-needed");
            } else {
                document.forms["subscribeForm"]["userNameSubscribe"].classList.remove("required-field-needed");
            }

            var atPosition = this.userEmailSubscribe.indexOf("@");
            var dotPosition = this.userEmailSubscribe.lastIndexOf(".");
            var lastEmailCharacter = this.userEmailSubscribe.length - 1;
            var validEmail = true;
            if (!this.userEmailSubscribe) {
                validEmail = false;
            } else if (atPosition <= 0) {
                validEmail = false;
            } else if (atPosition + 1 >= dotPosition) {
                validEmail = false;
            } else if (dotPosition + 1 >= lastEmailCharacter) {
                validEmail = false;
            }
            if (validEmail === false) {
                this.errors.push("Please enter a valid email.");
                document.forms["subscribeForm"]["userEmailSubscribe"].classList.add("required-field-needed");
            } else {
                document.forms["subscribeForm"]["userEmailSubscribe"].classList.remove("required-field-needed");
            }
            
            if(this.errors.length === 0){
                return true;
            } else {
                event.preventDefault();
                return false;
            }
        },
        setClickedSubmitTrue: function (){
            this.clickedSubmit = true;
        }
    },
    computed: {
        writeResponse: function () {
            var response = "";     
            if (this.clickedSubmit) {
                this.validateSubscribeForm(event);
            }         
            return response;
        }
    } 
});
/*End of section.*/



/*Recipes: hover picture to display hidden text. */
Vue.component('recipe-component', {
    template: '<div class="recipe__background-container" id="recipeCont1" v-on:mouseover="zoomIntoImage();" v-on:mouseout="zoomIntoImage();">\n\
<div class="recipe__background" :style="recipe__background"></div><div class="recipe__background-text" :style="recipe__backgroundtext">\n\
Flaky and full of flavor!</div></div>',
// props: ['recipe__background', 'recipe__backgroundtext'], 
    data: function () {
        return {
            zoomedIn: false,
            recipe__background: {
                opacity: 1
            },
            recipe__backgroundtext: {
                opacity: 0
            }
        }
    },
    methods: {
        zoomIntoImage: function () {
            this.zoomedIn = !this.zoomedIn;
            // alert("zoomedin" + this.zoomedIn);
            if (this.zoomedIn) {
                this.recipe__background.opacity = "0.25";
                this.recipe__backgroundtext.opacity = "1";
                this.recipe__backgroundtext.fontStyle = "italic";
            } else {
                this.recipe__background.opacity = "1";
                this.recipe__backgroundtext.opacity = "0";
                this.recipe__backgroundtext.fontStyle = "normal";
            }
        }
    }
});

var rec1 = new Vue({
    el: '#recipeCont1'
});
var rec2 = new Vue({
    el: '#recipeCont2'
});
var rec3 = new Vue({
    el: '#recipeCont3'
});
var rec4 = new Vue({
    el: '#recipeCont4'
});
/*End of section*/



/*Recipes section 'More-info' button*/
new Vue({
    el: '.recipe-more-info--one',
    data: {
        show: false
    }
});
new Vue({
    el: '.recipe-more-info--two',
    data: {
        show: false
    }
});
new Vue({
    el: '.recipe-more-info--three',
    data: {
        show: false
    }
});
new Vue({
    el: '.recipe-more-info--four',
    data: {
        show: false
    }
});
/*End of Section*/
