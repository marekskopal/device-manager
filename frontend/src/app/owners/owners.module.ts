import { NgModule } from '@angular/core';
import { ReactiveFormsModule } from '@angular/forms';
import { CommonModule } from '@angular/common';

import { OwnersRoutingModule } from './owners-routing.module';
import {FaIconComponent, FaIconLibrary} from "@fortawesome/angular-fontawesome";
import {faEdit, faPlus, faTrash} from "@fortawesome/free-solid-svg-icons";
import {ListComponent} from "@app/owners/components/list/list.component";
import {LayoutComponent} from "@app/owners/components/layout/layout.component";
import {AddEditComponent} from "@app/owners/components/add-edit/add-edit.component";

@NgModule({
    imports: [
        CommonModule,
        ReactiveFormsModule,
        OwnersRoutingModule,
        FaIconComponent
    ],
    declarations: [
        LayoutComponent,
        ListComponent,
        AddEditComponent
    ]
})
export class OwnersModule {
    public constructor(
        private readonly faIconLibrary: FaIconLibrary
    ) {
        faIconLibrary.addIcons(faPlus, faEdit, faTrash)
    }
}
