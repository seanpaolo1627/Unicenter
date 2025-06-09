import { createRouter, createWebHistory } from 'vue-router'

import EmployeeView from '../views/Employees/View.vue'
import EmployeeCreate from '../views/Employees/Create.vue'
import EmployeeEdit from '../views/Employees/Edit.vue'
import DepartmentView from '../views/Departments/View.vue'
import DepartmentCreate from '../views/Departments/Create.vue'
import DepartmentEdit from '../views/Departments/Edit.vue'
import DesignationView from "../views/Departments/View.vue"
import DesignationCreate from "../views/Departments/DCreate.vue"
import DesignationEdit from "../views/Departments/DEdit.vue"
import DesignationsView from "../views/Departments/DesignationsView.vue"
import AssignView from '../views/Assign/View.vue'
import AssignCreate from '../views/Assign/Create.vue'
import AssignEdit from '../views/Assign/Edit.vue'
import PayrollView from '../views/Payrolls/View.vue'
import PayrollCreate from '../views/Payrolls/Create.vue'
import PayrollEdit from '../views/Payrolls/Edit.vue'
import PayrollReport from '../views/Payrolls/Report.vue'



const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/employee',
      name: 'employee',
      component: EmployeeView
    },
    {
      path: '/employee/create',
      name: 'employeeCreate',
      component: EmployeeCreate
    },
    {
      path: '/employee/:id/edit',
      name: 'employeeEdit',
      component: EmployeeEdit
    },


    {
      path: '/departments',
      name: 'department',
      component: DepartmentView
    },
    {
      path: '/departments/create',
      name: 'departmentCreate',
      component: DepartmentCreate
    },
    {
      path: '/departments/:id/edit',
      name: 'departmentEdit',
      component: DepartmentEdit
    },


    {
      path: '/departments',
      name: 'designation',
      component: DesignationView
    },
    {
      path: '/designation/create', 
      name: 'designationCreate',
      component: DesignationCreate
    },
    {
      path: '/designation/:id/edit',
      name: 'designationEdit',
      component: DesignationEdit
    },
    {
      path: '/designation',
      name: 'designations',
      component: DesignationsView
    },


    {
      path: '/assign',
      name: 'assign',
      component: AssignView
    },
    {
      path: '/assign/create',
      name: 'assignCreate',
      component: AssignCreate
    },
    {
      path: '/assign/:id/edit',
      name: 'assignEdit',
      component: AssignEdit
    },
    {
      path: '/payrolls',
      name: 'payroll',
      component: PayrollView
    },
    {
      path: '/payrolls/create',
      name: 'payrollCreate',
      component: PayrollCreate
    },
    {
      path: '/payrolls/:id/edit',
      name: 'payrollEdit',
      component: PayrollEdit
    },
    {
      path: '/payrolls/report',
      name: 'payrollReport',
      component: PayrollReport
    },
  ]
})

export default router;