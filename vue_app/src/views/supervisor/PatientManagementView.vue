<template>
  <div class="page">
    <h1>老人管理</h1>
    <p class="sub">家庭养老床位建档 · 共 {{ patients.length }} 位</p>
    <table class="tbl">
      <thead><tr><th>姓名</th><th>性别</th><th>出生日期</th><th>地址</th><th>联系电话</th><th>紧急联系人</th></tr></thead>
      <tbody>
        <tr v-for="p in patients" :key="p.id">
          <td>{{ p.name }}</td><td>{{ genderText(p.gender) }}</td><td>{{ p.date_of_birth }}</td>
          <td>{{ p.address }}</td><td>{{ p.contact_phone }}</td><td>{{ p.emergency_contact_name }}</td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const patients = ref([]);
const genderText = (g) => g === 'female' ? '女' : g === 'male' ? '男' : '其他';
onMounted(async () => {
  const { data } = await axios.get('/api/supervisor/patients');
  patients.value = data;
});
</script>

<style scoped>
.page { padding: 24px; font-family: -apple-system, "Microsoft YaHei", sans-serif; }
h1 { margin: 0 0 4px; }
.sub { color: #6b7280; margin: 0 0 16px; }
.tbl { width: 100%; border-collapse: collapse; background: #fff; }
.tbl th, .tbl td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 14px; }
.tbl th { background: #f3f4f6; color: #23262e; }
.tbl tbody tr:hover { background: #fafafa; }
</style>
