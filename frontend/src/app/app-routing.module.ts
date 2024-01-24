import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import {AuthGuard} from "@app/core/guards/auth.guard";

const routes: Routes = [
    { path: '', loadChildren: () => import('./devices/devices.module').then(x => x.DevicesModule), canActivate: [AuthGuard] },
    { path: 'owners', loadChildren: () => import('./owners/owners.module').then(x => x.OwnersModule), canActivate: [AuthGuard] },
    { path: 'authentication', loadChildren: () => import('./authentication/authentication.module').then(x => x.AuthenticationModule) },

    // otherwise redirect to home
    { path: '**', redirectTo: '' }
];

@NgModule({
    imports: [RouterModule.forRoot(routes)],
    exports: [RouterModule]
})
export class AppRoutingModule { }
