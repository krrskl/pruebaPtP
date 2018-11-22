<template>
  <div class="body__home">
    <h4>
      <strong>Bienvenido! seleccione el método de pago que usará:</strong>
    </h4>
    <br>
    <button style="background-image: url('./../../images/icon_pse_128.png');"></button>

    <section class="section__selectPerson">
      <strong>Seleccione el tipo de cliente:</strong>
      <select v-model="selectedTypeClient">
        <option disabled value="">Seleccione uno</option>
        <option value="persona">Persona</option>
        <option value="empresa">Empresa</option>
      </select>
    </section>
  </div>
</template>

<script>
export default {
  data() {
    return {
      selectedTypeClient: ""
    };
  }
};
</script>


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