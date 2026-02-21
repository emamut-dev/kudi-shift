console.log(miPlugin.userRoles); // ["administrator"], ["editor"], etc.
console.log(miPlugin.isAdmin); // true o false

if (miPlugin.userRoles.includes('administrator')) {
  // lógica para admins
}
