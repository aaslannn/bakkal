<?php namespace App\Http\Controllers;
use Sentry;
use View;
use Validator;
use Input;
use Redirect;
use Lang;
use URL;
use Cartalyst\Sentry\Groups\GroupNotFoundException;

class GroupsController extends MainController
{
    public function __construct()
    {
        $this->beforeFilter(function(){
            if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups'))
            {
                return Redirect::to('/admin')->with('error', Lang::get('general.nopermission'));
            }
        });
    }

    /**
     * Show a list of all the groups.
     *
     * @return View
     */
    public function getIndex()
    {
        // Grab all the groups
        $groups = Sentry::getGroupProvider()->createModel()->paginate();

        // Show the page
        return View('admin/groups/index', compact('groups'));
    }

    /**
     * Group create.
     *
     * @return View
     */
    public function getCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups_add'))
            return Redirect::to('/admin/groups')->with('error', Lang::get('general.nopermission'));

        return View('admin/groups/create');
    }

    /**
     * Group create form processing.
     *
     * @return Redirect
     */
    public function postCreate()
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups_add'))
            return Redirect::to('/admin/groups')->with('error', Lang::get('general.nopermission'));

        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required|unique:groups',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            // Get the inputs, with some exceptions
            $inputs = Input::except('_token');

            // Was the group created?
            if ($group = Sentry::getGroupProvider()->create($inputs)) {
                // Redirect to the new group page
                return Redirect::route('groups')->with('success', Lang::get('groups/message.success.create'));
            }

            // Redirect to the new group page
            return Redirect::route('create/group')->with('error', Lang::get('groups/message.error.create'));
        } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
            $error = 'group_name_required';
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e) {
            $error = 'group_exists';
        }

        // Redirect to the group create page
        return Redirect::route('create/group')->withInput()->with('error', Lang::get('groups/message.'.$error));
    }

    /**
     * Group update.
     *
     * @param  int  $id
     * @return View
     */
    public function getEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups_edit'))
            return Redirect::to('/admin/groups')->with('error', Lang::get('general.nopermission'));
        
        try {
            // Get the group information
            $group = Sentry::findGroupById($id);

        } catch (GroupNotFoundException $e) {
            // Redirect to the groups management page
            return Redirect::route('groups')->with('error', Lang::get('groups/message.group_not_found', compact('id')));
        }

        // Show the page
        return View('admin/groups/edit', compact('group'));
    }

    /**
     * Group update form processing page.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function postEdit($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups_edit'))
            return Redirect::to('/admin/groups')->with('error', Lang::get('general.nopermission'));

        try {
            // Get the group information
            $group = Sentry::getGroupProvider()->findById($id);
        } catch (GroupNotFoundException $e) {
            // Redirect to the groups management page
            return Rediret::route('groups')->with('error', Lang::get('groups/message.group_not_found', compact('id')));
        }

        // Declare the rules for the form validation
        $rules = array(
            'name' => 'required',
        );

        // Create a new validator instance from our validation rules
        $validator = Validator::make(Input::all(), $rules);

        // If validation fails, we'll exit the operation now.
        if ($validator->fails()) {
            // Ooops.. something went wrong
            return Redirect::back()->withInput()->withErrors($validator);
        }

        try {
            // Update the group data
            $group->name        = Input::get('name');
            $group->description  = Input::get('description');
            $group->permissions = Input::get('permissions');

            // Was the group updated?
            if ($group->save()) {
                // Redirect to the group page
                return Redirect::route('groups')->with('success', Lang::get('groups/message.success.update'));
            } else {
                // Redirect to the group page
                return Redirect::route('update/group', $id)->with('error', Lang::get('groups/message.error.update'));
            }
        } catch (Cartalyst\Sentry\Groups\NameRequiredException $e) {
            echo 'Name field is required';
        } catch (Cartalyst\Sentry\Groups\GroupExistsException $e)
        {
            return Redirect::route('update/group', $id)->with('error', Lang::get('groups/message.error.group_exists'));
        } catch (Cartalyst\Sentry\Groups\GroupNotFoundException $e)
        {
            echo 'Group was not found.';
        }
    }

    /**
     * Delete confirmation for the given group.
     *
     * @param  int      $id
     * @return View
     */
    public function getModalDelete($id = null)
    {
        $model = 'groups';
        $confirm_route = $error = null;
        try {
            // Get group information
            $group = Sentry::getGroupProvider()->findById($id);


            $confirm_route =  route('delete/group',['id'=>$group->id]);
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        } catch (GroupNotFoundException $e) {

            $error = Lang::get('admin/groups/message.group_not_found', compact('id'));
            return View('admin/layouts/modal_confirmation', compact('error', 'model', 'confirm_route'));
        }
    }

    /**
     * Delete the given group.
     *
     * @param  int      $id
     * @return Redirect
     */
    public function getDelete($id = null)
    {
        if (!Sentry::getUser()->hasAccess('admin') && !Sentry::getUser()->hasAccess('groups_add'))
            return Redirect::to('/admin/groups')->with('error', Lang::get('general.nopermission'));

        try {
            // Get group information
            $group = Sentry::getGroupProvider()->findById($id);

            // Delete the group
            $group->delete();

            // Redirect to the group management page
            return Redirect::route('groups')->with('success', Lang::get('groups/message.success.delete'));
        } catch (GroupNotFoundException $e) {
            // Redirect to the group management page
            return Redirect::route('groups')->with('error', Lang::get('groups/message.group_not_found', compact('id')));
        }
    }

}
