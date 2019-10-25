<template>
  <div id="app" class="app">
      <router-view />
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator';

@Component({
  components: {
  },
})
export default class App extends Vue {}
</script>

<style lang="scss">
body {
    background-color: #004C70;
    font-family: 'Indie Flower', cursive;
    color: white;
}
</style>

<style lang="scss" scoped>
    .app {
        width: 90%;
        max-width: 800px;
        margin: 20px auto;
    }
</style>
