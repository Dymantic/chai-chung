import axios from "axios";
import {notify} from "../components/notify";
import {subDays} from "date-fns";


export default {
    namespaced: true,

    state: {
        sessions: [],
        sessions_start: subDays(new Date(), 14),
        sessions_end: new Date(),
        clients: [],
        engagements: [],
        service_periods: [],
    },

    getters: {
        date_query: state => `from=${state.sessions_start.toISOString().slice(0, 10)}&to=${state.sessions_end.toISOString().slice(0, 10)}`,

        filteredByClient: state => client_id => {
            if(!client_id) {
                return state.sessions;
            }

            return state.sessions.filter(s => parseInt(s.client_id) === parseInt(client_id));
        }
},

    mutations: {
        start_date(state, starts) {
            state.sessions_start = starts;
        },

        end_date(state, ends) {
            state.sessions_end = ends;
        },

        reset_dates(state) {
            state.sessions_start = subDays(new Date(), 14);
            state.sessions_end = new Date();
        }
    },


    actions: {

        fetchSessions({state, getters}, query) {
            return new Promise((resolve, reject) => {
                const q = `${getters.date_query}&client_id=`;
                axios.get(`/admin/sessions?${q}`)
                     .then(({data}) => {
                         state.sessions = data;
                         resolve();
                     })
                     .catch(() => reject({message: '系統無法顯示時間紀錄'}));
            });
        },

        fetchClientsList({state}) {
            return new Promise((resolve, reject) => {
               axios.get("/admin/clients")
                   .then(({data}) => {
                       state.clients = data;
                       resolve();
                   })
                   .catch(() => reject({message: '無法讀取客戶清單'}));
            });

        },

        fetchEngagementCodes({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/engagement-codes")
                     .then(({data}) => {
                         state.engagements = data;
                         resolve();
                     })
                     .catch(() => reject({message: '無法讀取工作事項'}));
            });
        },

        fetchServicePeriods({state}) {
            return new Promise((resolve, reject) => {
                axios.get("/admin/service-periods")
                     .then(({data}) => {
                         state.service_periods = data;
                         resolve();
                     })
                     .catch(() => reject({message: '無法讀取服務期間資料'}));
            });
        },

        inflate({dispatch}) {
            dispatch('fetchClientsList').catch(notify.error);
            dispatch('fetchEngagementCodes').catch(notify.error);
            dispatch('fetchServicePeriods').catch(notify.error);
        },

        getSession({state}, session_id) {
            return new Promise((resolve, reject) => {
               axios.get(`/admin/sessions/${session_id}`)
                   .then(({data}) => resolve(data))
                   .catch(() => reject({message: '無法顯示時間紀錄'}));
            });
        },

        saveSession({state, dispatch}, {formData, id = null}) {
            const url = id ? `/admin/sessions/${id}` : '/admin/sessions';
            return new Promise((resolve, reject) => {
                axios.post(url, formData)
                    .then(() => {
                        dispatch('fetchSessions').catch(notify.error);
                        resolve();
                    })
                    .catch(({response}) => reject(response));
            });
        }
    }
}
