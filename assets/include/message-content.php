<div class="inner-wrapper">
    <div class="message" v-on:mouseover="changeText" v-on:mouseout="changeText" v-bind:style="message">
        <p class="message__text"> {{messageText}}</p>
    </div>
</div>