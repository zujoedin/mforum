function page (path) {
  return () => import(/* webpackChunkName: '' */ `~/pages/${path}`).then(m => m.default || m)
}

export default [
  { path: '/', name: 'welcome', component: page('Home.vue') },
  { path: '/home', name: 'home', component: page('Home.vue') },
  { path: '/myquestions', name: 'myquestions', component: page('Myquestions.vue') },
  { path: '/home/:id', name: 'answers', component: page('Answers.vue') },
  { path: '/notifications', name: 'notifications', component: page('Notifications.vue') },
  { path: '/login', name: 'login', component: page('auth/login.vue') },
  { path: '/register', name: 'register', component: page('auth/register.vue') },  
  { path: '/password/reset/:token', name: 'password.reset', component: page('auth/password/reset.vue') },
  { path: '/email/verify/:id', name: 'verification.verify', component: page('auth/verification/verify.vue') },
  { path: '/email/resend', name: 'verification.resend', component: page('auth/verification/resend.vue') },

  
  {
    path: '/settings',
    component: page('settings/index.vue'),
    children: [
      { path: '', redirect: { name: 'settings.profile' } },
      { path: 'profile', name: 'settings.profile', component: page('settings/profile.vue') },
      { path: 'password', name: 'settings.password', component: page('settings/password.vue') },
      { path: 'config', name: 'settings.config', component: page('settings/config.vue') }
    ]
  },

 
  { path: '*', component: page('errors/404.vue') }
]
