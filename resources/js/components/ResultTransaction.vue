<template>
  <div class="body__home">
    <h4>
      <strong>Información de la última transacción realizada por usted:</strong>
    </h4>
    <br>
    <table>
      <tr>
        <th>
          <strong>Referencia</strong>
        </th>
        <th>{{transaction.reference}}</th>
      </tr>

      <tr>
        <th>
          <strong>Estado</strong>
        </th>
        <th>{{transaction.transactionState}}</th>
      </tr>

      <tr>
        <th>
          <strong>Motivo del estado</strong>
        </th>
        <th>{{transaction.responseReasonText}}</th>
      </tr>

      <tr>
        <th>
          <strong>Fecha</strong>
        </th>
        <th>{{transaction.requestDate}}</th>
      </tr>
    </table>
  </div>
</template>

<script>
import axios from "axios";
export default {
  data() {
    return {
      transaction: []
    };
  },
  mounted() {
    axios.get("http://localhost:8000/resultTransaction").then(response => {
      this.transaction = response.data.response;
    });
  },
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
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td,
th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>

