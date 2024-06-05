<template>
          <div>
            <a @click="goBack" class="btn btn-outline-primary mt-2 mb-2">Regresar</a>
        </div>
</template>

<script>
export default {
    methods: {
    goBack() {
      window.history.back();
    }
  }
}
</script>

<style>

</style>