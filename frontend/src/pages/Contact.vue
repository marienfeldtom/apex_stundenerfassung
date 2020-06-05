<template>
    <q-page padding>
      <q-table
        title="Kunden"
        :data="data"
        :columns="columns"
        selection="single"
        :selected.sync="selected"
        row-key="name"
      />
    </q-page>
</template>

<script>
    export default {
        props: ['products'],
        data() {
            return {
              drawer: false,
              selected: [],
              columns: [
                {
                  name: 'id',
                  required: true,
                  label: 'ID',
                  align: 'left',
                  field: row => row.name,
                  format: val => `${val}`,
                  sortable: true
                },
                {
                  name: 'name',
                  align: 'left',
                  label: 'Name',
                  field: 'name',
                  sortable: true
                },
                {
                  name: 'totalTime',
                  label: 'Stunden',
                  field: 'totalTime',
                  sortable: true
                }
              ],
              data: [
                {
                  id: 1,
                  name: 'Stadt Meldorf',
                  totalTime: '02:30'
                },
                {
                  id: 2,
                  name: 'Bädtker',
                  totalTime: '04:30'
                },
                {
                  id: 3,
                  name: 'EFH Münster',
                  totalTime: '01:00'
                }
              ]
            }
        }
    }
</script>
