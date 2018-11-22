<template>
  <div class="body__home">
    <strong>Bienvenido! seleccione el método de pago que usará:</strong>
    <br>
    <button style="background-image: url('./../../images/icon_pse_128.png');"></button>
  </div>
</template>

<style scoped>
.body__home {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}
button {
  width: 100px;
  height: 100px;
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
  border: none;
  border-radius: 50%;
  cursor: pointer;
}
</style>