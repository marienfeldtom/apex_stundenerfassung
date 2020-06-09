<template>
  <FullCalendar
    defaultView="timeGridWeek"
    :plugins="calendarPlugins"
    timeZone="UTC"
    slotDuration="00:15:00"
    :customButtons="customButtons"
    :locale="locale"
    :contentHeight="800"
    :weekends="false"
    :firstHour="7"
    :header=" {
      left: 'title, prev,next , today',
    center: 'dayView, timeGridWeek',
    right: 'newEvent',
  }"
    editable="true"
    :events='[{"id":28,"start":"2020-06-10 10:45:00","end":"2020-06-10 14:45:00","title":"Heizungsanlage Schwimmbad Meldorf"},{"id":29,"start":"2020-06-11 11:45:00","end":"2020-06-11 16:30:00","title":"B\u00e4dtker"},{"id":30,"start":"2020-06-08 10:15:00","end":"2020-06-08 14:45:00","title":"Heizungsanlage Schwimmbad Meldorf"},{"id":31,"start":"2020-06-09 12:00:00","end":"2020-06-09 16:00:00","title":"Vaillant Heizungsanlage"}]'
    :views="{
        timeGridWeek: {
          type: 'timeGrid',
          firstDay: 1,
          buttonText: 'Woche'
        },
        dayView: {
          type: 'timeGridDay'
        }
      }"
    :eventOverlap=" function(stillEvent, movingEvent) {
    return stillEvent.allDay && movingEvent.allDay;
    }"
    @eventDrop="updateEvent"
    @eventResize="updateEvent"

  />
</template>

<script>

  import FullCalendar from '@fullcalendar/vue'
  import dayGridPlugin from '@fullcalendar/daygrid'
  import timeGridPlugin from '@fullcalendar/timegrid'
  import interactionPlugin from '@fullcalendar/interaction'
  import deLocale from '@fullcalendar/core/locales/de';
  import Swal from 'sweetalert2'

  export default {
    components: {
      FullCalendar // make the <FullCalendar> tag available
    },
    data() {
      return {
        calendarPlugins: [dayGridPlugin, timeGridPlugin, interactionPlugin],
        locale: deLocale,
        customButtons: {
          newEvent: {
            text: 'Neuer Eintrag',
            click: () => this.newEvent()
          }
        }
      }
    },
    methods: {
      updateEvent: function (info) {
        const start = new Date(info.event.start).getDate();
        const end = new Date(info.event.end).getDate();
        if (end > start) {
          Swal.fire({
            icon: 'error',
            title: 'Einträge über mehrere Tage sind nicht erlaubt!',
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 6000,
            timerProgressBar: true,
            onOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })
          info.revert();
        } else {


          Swal.fire({
            title: 'Bist du sicher?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'Abbrechen',
            confirmButtonText: 'Ja!'
          }).then((result) => {
            if (result.value) {
              /*axios.patch("/updateTimeEntry", {
                start: info.event.start,
                end: info.event.end,
                id: info.event.id
              })*/
              Swal.fire({
                icon: 'success',
                title: 'Eintrag erfolgreich geändert!',
                toast: true,
                position: 'bottom-end',
                showConfirmButton: false,
                timer: 6000,
                timerProgressBar: true,
                onOpen: (toast) => {
                  toast.addEventListener('mouseenter', Swal.stopTimer)
                  toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
              })
            } else {
              info.revert();
            }
          })
        }
      },
      newEvent: async function () {


        Swal.mixin({
          confirmButtonText: 'Weiter &rarr;',
          showCancelButton: true,
          cancelButtonText: "Abbrechen",
          progressSteps: ['1', '2', '3', '4', '5']
        }).queue([
          {
            title: 'Baustelle auswählen',
            input: 'select',
            inputOptions: {
              'Hotelverwaltung Eckernförde': {
                1: 'Heizung Hotel',
                2: 'Gastank Draußen',
                3: 'Wasserrohr Flur',
              },
              'Stadt Meldorf': {
                1: 'Vaillant Heizungsanlage',
                2: 'Wassertank'
              }
            },
            inputPlaceholder: 'Baustelle auswählen',
            showCancelButton: true,
          },
          {
            title: 'Start Uhrzeit',
            input: 'text',
            showCancelButton: true,
          },
          {
            title: 'End Uhrzeit',
            input: 'text',
            showCancelButton: true,
          },
          {
            title: 'Kommentar',
            input: 'text',
            showCancelButton: true,
          },
        ]).then((result) => {
          if (result.value) {
            const answers = JSON.stringify(result.value)
            Swal.fire({
              title: 'Eintrag gespeichert!',
              icon: 'success',
              html: `
        Baustelle: ${result.value[0]} <br>
        Von: ${result.value[1]} <br>
        Bis: ${result.value[2]} <br>
        Kommentar: ${result.value[3]} <br>
      `,
              confirmButtonText: 'Schließen!'
            })
          }
        })







      }
    }
  }

</script>

