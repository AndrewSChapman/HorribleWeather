<template>
  <div class="home">
      <div class="logo">
        <img alt="Horrible Weather logo" src="./../assets/storm.svg" width="60%" />
      </div>

      <h1>The location with the most deplorable weather is...</h1>

      <WeatherListing />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';
import WeatherListing from '@/components/domains/weather/WeatherListing.vue';

@Component({
    components: {
        WeatherListing,
    },
})
export default class Home extends Vue {

}
</script>

<style lang="scss" scoped>
    .logo {
        opacity: 1;
        text-align: center;
        animation: fadein 2s;
    }


    @keyframes fadein {
        from { opacity: 0; }
        to   { opacity: 1; }
    }
</style>
