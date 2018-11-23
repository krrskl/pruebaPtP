<template>
  <div class="body__home">
    <h4>
      <strong>Bienvenido! seleccione el método de pago que usará:</strong>
    </h4>
    <br>
    <button class="button__pse"></button>

    <strong>Seleccione el tipo de cliente:</strong>
    <select  @change="event()" v-model="selectedTypeClient">
      <option disabled value="">Seleccione uno</option>
      <option value="persona">Persona</option>
      <option value="empresa">Empresa</option>
    </select>
    <br>

    <div v-if="selectedTypeClient">
      <strong>Seleccione su banco:</strong>
      <select @change="redirect()" v-model="selectedBank">
        <option v-for="item in banks" :key="item.id" :value="item.bankCode">{{item.bankName}}</option>
      </select>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      selectedTypeClient: "",
      selectedBank: "",
      banks: []
    };
  },
  methods: {
    event() {
      axios.get("http://127.0.0.1:8000/getBankList").then(response => {
        this.banks = response.data.data.item;
      });
    },
    redirect() {
      
    }
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
.button__pse {
  width: 100px;
  height: 100px;
  background-image: url("./../../images/icon_pse_128.png");
  background-size: contain;
  background-repeat: no-repeat;
  background-position: center;
}
.button__action,
.button__pse {
  border: none;
  border-radius: 50%;
  cursor: pointer;
  outline: none;
}

.button__action {

}
</style>