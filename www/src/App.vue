<template>
  <div id="app">
    <router-view/>
  </div>
</template>

<script>
export default {
  name: 'app'
}
</script>

<style>
  body {
    position: absolute !important;
    background-color: #f8f8f9 !important;
    top: 0;
    left: 0;
    right: 0;
    padding-bottom: 100px !important;
    min-height: 100%;
    font-size: 15px !important;
  }
  .article-content pre code {
    display: block;
  }
  .article-content code {
    background-color: #f8f8f9;
    border-radius: 3px;
    padding: 3px 5px;
  }
  img {
    max-width:100%;
  }
</style>
