<template>
  <div class="page">
    <h1>派工排班</h1>
    <p class="sub">把照护计划拆成任务派给护理员 · 共 {{ assignments.length }} 单</p>
    <table class="tbl">
      <thead><tr><th>老人</th><th>护理员</th><th>计划时间</th><th>状态</th></tr></thead>
      <tbody>
        <tr v-for="a in assignments" :key="a.id">
          <td>{{ a.care_plan?.patient?.name }}</td><td>{{ a.assigned_to_user?.name }}</td>
          <td>{{ a.scheduled_start_at }} ~ {{ a.scheduled_end_at }}</td>
          <td><span class="tag">{{ statusText(a.status) }}</span></td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
const assignments = ref([]);
const statusText = (s) => ({ scheduled: '待服务', completed: '已完成', cancelled: '已取消', missed: '未到岗' })[s] || s;
onMounted(async () => {
  const { data } = await axios.get('/api/supervisor/assignments');
  assignments.value = data;
});
</script>

<style scoped>
.page { padding: 24px; font-family: -apple-system, "Microsoft YaHei", sans-serif; }
h1 { margin: 0 0 4px; }
.sub { color: #6b7280; margin: 0 0 16px; }
.tbl { width: 100%; border-collapse: collapse; background: #fff; }
.tbl th, .tbl td { border: 1px solid #e5e7eb; padding: 10px 12px; text-align: left; font-size: 14px; }
.tbl th { background: #f3f4f6; color: #23262e; }
.tag { background: #fef3c7; color: #b45309; padding: 2px 8px; border-radius: 4px; font-size: 12px; }
</style>
