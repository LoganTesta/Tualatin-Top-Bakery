
/*Used sitewide on the message section near the bottom.*/
var messageTextApp = new Vue({
    el: '.message',
    data: {
        messageText: "What's baking in the oven?",
        message1: "What's baking in the oven?",
        message2: "Coooookies!",
        showMessage: false,
        message: {
               backgroundColor:""     
        }
    },
    methods: {
        changeText: function (event) {
            console.log(event);
            this.showMessage = !this.showMessage;
            if (this.showMessage) {
                this.messageText = this.message2;
                this.message.backgroundColor="#64460e";
            } else {
                this.messageText = this.message1;
                this.message.backgroundColor="#ac8949";
            }
        }
    }
});
/*End of section.*/



/*Contact form live response*/
var contactUpdatedResponseApp =new Vue ({
    el: '#contactContainer',
    data: {
        userFirstName: "",
        userLastName:"",
        userSubject: ""      
    },
    computed : {
       writeResponse : function(){
           var response=this.userFirstName+" " + this.userLastName;
           return response;
       }
    }
            
});
/*End of section.*/



/*Careers form live response*/
var careersUpdatedResponseApp =new Vue ({
    el: '#careersContainer',
    data: {
        userName: ""
    },
    computed : {
       writeResponse : function(){
           var response=this.userName;
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
    data: function(){
      return {
          zoomedIn: false,
          recipe__background : {
              opacity: 1
          },
          recipe__backgroundtext : {
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
                this.recipe__backgroundtext.fontStyle="italic";
            } else {
                this.recipe__background.opacity = "1";
                this.recipe__backgroundtext.opacity = "0";
                this.recipe__backgroundtext.fontStyle="normal";
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



/*Used sitewide in the footer: subscribe button/modal. */
Vue.component('modal', {
    template: '#modal-template'
});

new Vue({
    el: '.footer__subscribe',
    data: {
        showModal: false
    }
});
/*End of section.*/

