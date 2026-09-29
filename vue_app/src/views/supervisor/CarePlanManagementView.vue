<template>
  <div class="page">
    <h1>照护计划</h1>
    <p class="sub">按老人定制服务计划 · 共 {{ plans.length }} 条</p>
    <table class="tbl">
      <thead><tr><th>老人</th><th>服务项目</th><th>频率</th><th>时长</th><th>开始日期</th><th>状态</th></tr></thead>
      <tbody>
        <tr v-for="cp in plans" :key="cp.id">
          <td>{{ cp.patient?.name }}</td><td>{{ cp.service_item?.name }}</td><td>{{ cp.frequency }}</td>
          <td>{{ cp.duration_minutes }} 分钟</td><td>{{ cp.start_date }}</td>
          <td><span class="tag">{{ cp.status }}</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const plans = ref([]);
onMounted(async () => {
  const { data } = await axios.get('/api/supervisor/care-plans');
  plans.value = data;
});
</script>

<style scoped>
.page { padding: 24px; font-family: -apple-system, "Microsoft YaHei", sans-serif; }
h1 { margin: 0 0 4px; }
.sub { color: #6b7280; margin: 0 0 16px; }
.tbl { width: 100%; border-collapse: collapse; background: #fff; }
.tbl th, .tbl td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 14px; }
.tbl th { background: #f3f4f6; color: #23262e; }
.tag { background: #eef2ff; color: #4f46e5; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
</style>
