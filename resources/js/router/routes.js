function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('welcome.vue') },

  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },
  { path: '/password/reset', name: 'password.request', component: page('auth/password/email.vue') },
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  { path: '/rooms', name: 'rooms', component: page('rooms/rooms.vue') },
  { path: '/room/:id', name: 'room', component: page('rooms/room.vue') },

  { path: '/users', name: 'users', component: page('users/users.vue') },
  { path: '/user/:id', name: 'user', component: page('users/user.vue') },

  { path: '/enquete/:id', name: 'enquete', component: page('enquete/enquete.vue') },

  { path: '/analytics', name: 'analytics', component: page('analytics/analytics.vue') },

  { path: '/appointments', name: 'appointments', component: page('appointments/appointments.vue') },
  { path: '/viewAppointments', name: 'viewAppointments', component: page('appointments/viewAppointments.vue') },
  { path: '/viewAppointment/:id', name: 'viewAppointment', component: page('appointments/viewAppointment.vue') },

  { path: '/home', name: 'home', component: page('home.vue') },
  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') }
    ]
  },

  { path: '*', component: page('errors/404.vue') }
]
