<template>
  <div class="subscription-card">
    <h2>{{ subscription.student.name }}</h2>
    <span>{{ subscription.plan.name }}</span>
    <div class="subscription-card-details">
      <div>
        Início: {{ $filters.data(subscription.dt_start) }}
      </div>
      <div>
        Fim: {{ $filters.data(subscription.dt_end) }}
      </div>
    </div>
    <div class="subscription-card-actions">
      <button class="btn btn-full btn-primary" @click="abrirEdicao">
        Editar
      </button>
      <button class="btn btn-full btn-danger" @click="abrirExclusao">
        Excluir
      </button>
    </div>
  </div>
</template>

<script>
import {mapMutations} from "vuex";

export default {
  name: "SubscriptionCard",
  props: ["data"],
  data() {
    return {
      subscription: this.data
    }
  },
  methods: {
    abrirEdicao() {
      this.$eventBus.$emit("ModalEditSubscription:config", {
        id: this.subscription.id
      });
    },
    abrirExclusao() {
      this.$eventBus.$emit("ModalRemoveSubscription:config", {
        id: this.subscription.id
      });
    },
  },
  watch: {
    data(valor) {
      this.subscription = valor;
    }
  }
}
</script>

<style scoped>
.subscription-card {
  background: #fff;
  border-radius: 4px;
  padding: 30px;
}

.subscription-card h2 {
  color: #444444;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 10px;
  text-transform: uppercase;
  text-align: center;
}

.subscription-card span {
  display: block;
  color: #999;
  font-size: 14px;
  margin-bottom: 10px;
  text-transform: uppercase;
  font-weight: 700;
  text-align: center;
}

.subscription-card-details {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
  gap: 10px;

  justify-content: center;
}

.subscription-card-details > div {
  color: #444444;
  font-size: 16px;
  font-weight: 700;
  margin-bottom: 10px;
  text-transform: uppercase;
}

.subscription-card-actions {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 20px;
}
</style>
