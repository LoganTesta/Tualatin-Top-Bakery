<div class="message" v-on:mouseover="changeText" v-on:mouseout="changeText" v-bind:style="message">
    <div class="inner-wrapper">
        <div class="message__additional-wrapper">
            <div class="message__text">{{messageText}}</div>
        </div>
    </div>
</div>