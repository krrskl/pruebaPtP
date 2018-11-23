<template>
  <div>
    <div class="body__home">
      <h4>
      <strong>Bienvenido! seleccione el método de pago que usará:</strong>
      </h4>
      <br>
      <button class="button__pse" v-on:click="sectionPSE = true"></button>

      <section v-if="sectionPSE">
        <br>
        <strong>Seleccione el tipo de cliente:</strong>
        <select @change="event()" v-model="selectedTypeClient">
          <option disabled value="">Seleccione uno</option>
          <option value="0">Persona</option>
          <option value="1">Empresa</option>
        </select>
        <br>
        <br>
        <div v-if="selectedTypeClient">
          <strong v-bind:class="{info__select: !banks.length}">Seleccione su banco: <i class="material-icons loading"
              v-if="!banks.length">loop</i></strong>
          <select v-model="selectedBank" v-if="banks.length">
            <option v-for="item in banks" :key="item.id" :value="item.bankCode">{{item.bankName}}</option>
          </select>
        </div>
        <br>
        <button v-on:click="redirect()" class="button__action" :disabled="!selectedBank">Continuar</button>
      </section>
    </div>

    <div class="ui-snackbar-container">
      <div class="ui-snackbar" v-show="show" transition="ui-snackbar-toggle">
          <div class="ui-snackbar-text">{{messageSnack}}</div>
          <div class="ui-snackbar-action">
              <button v-on:click="show = !show">Ok</button>
          </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      selectedTypeClient: "",
      selectedBank: 1022,
      banks: [],
      sectionPSE: false,
      show: false,
      messageSnack: ""
    };
  },
  methods: {
    ID() {
      return (
        "_" +
        Math.random()
          .toString(36)
          .substr(2, 9)
      );
    },
    event() {
      axios.get("http://127.0.0.1:8000/getBankList").then(response => {
        this.banks = response.data.data.item;
      });
    },
    redirect() {
      axios
        .post("http://localhost:8000/createTransaction", {
          headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
          },
          bankCode: this.selectedBank,
          bankInterface: this.selectedTypeClient,
          description: "Pago de prueba",
          reference: this.ID(),
          language: "ES",
          currency: "COP",
          totalAmount: 200500,
          taxAmount: 0,
          devolutionBase: 0,
          tipAmount: 0,
          payer: 1,
          buyer: 4,
          shipping: 7
        })
        .then(response => {
          console.log(response.data.response.bankURL);
          location.href = response.data.response.bankURL;
        })
        .catch(error => {
          this.show = !this.show;
          this.messageSnack = "Lo sentimos, ha ocurrido un error.";
        });
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
  display: flex;
  flex-direction: column;
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
  background: #0c3f71;
  color: #fff;
  height: 40px;
  width: 200px;
  border: none;
  border-radius: 22px;
  text-transform: uppercase;
  font-size: large;
  font-weight: bold;
}

.button__action:disabled,
.button__action[disabled] {
  background-color: #95aec7 !important;
}

.loading {
  -webkit-animation: rotation 2s infinite linear;
}

.info__select {
  display: flex;
}

@-webkit-keyframes rotation {
  from {
    -webkit-transform: rotate(0deg);
  }

  to {
    -webkit-transform: rotate(359deg);
  }
}

/* snackbar style */
.ui-snackbar-container {
  position: absolute;
  overflow: hidden;
  bottom: 5px;
  right: 10px;
}

.ui-snackbar {
  display: inline-flex;
  align-items: center;
  min-width: 288px;
  max-width: 568px;
  min-height: 48px;
  padding: 14px 24px;
  margin: 4px 4px 8px 4px;
  border-radius: 2px;
  background-color: #323232;
  box-shadow: 0 1px 3px alpha(black, 0.12), 0 1px 2px alpha(black, 0.24);
}

.ui-snackbar-text {
  font-size: 14px;
  color: white;
}

.ui-snackbar-action {
  margin-left: auto;
  padding-left: 48px;
}

.ui-snackbar-action button {
  border: none;
  background: none;
  margin: 0;
  padding: 0;
  font-size: 14px;
  text-transform: uppercase;
  color: #ffeb3b;
  cursor: pointer;
}
.ui-snackbar-toggle-transition {
  transition: transform 0.3s ease;
}
.ui-snackbar-text,
.ui-snackbar-action {
  opacity: 1;
  transition: opacity 0.3s ease;
}
.ui-snackbar-toggle-enter,
.ui-snackbar-toggle-leave {
  transform: translateY(60px);
}
</style>