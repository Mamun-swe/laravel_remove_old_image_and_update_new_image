    public function update(Request $request, $id)
    {
        $valid = false;
        $rules = [
            'name' => 'required',
            'cashback' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'short_description' => 'required'
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages(),
            ], 422);
        }else{
            if ($request->hasFile('image')){
                $file = $request->file('image');
                $extension = $file->getClientOriginalExtension();
                $filename = time(). '.' . $extension;
                

                $data = Campaign::find($id);
                $old_image = public_path().'/campaigns/'.$data->image;
                unlink($old_image);

                $file->move('campaigns', $filename);
                $form_data = array(
                    'name' => $request->name,
                    'cashback' => $request->cashback,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'short_description' => $request->short_description,
                    'image' => $filename
                );

                Campaign::where('id', '=', $id)->update($form_data);
                $valid = true;

                if($valid == true) {
                    return response()->json(['message' => 'Successfully updated' ], 200);
                } else {
                    return response()->json(['message' => 'Failed to update'], 204);
                }
            }else{
                $form_data = array(
                    'name' => $request->name,
                    'cashback' => $request->cashback,
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'short_description' => $request->short_description
                );

                Campaign::where('id', '=', $id)->update($form_data);
                $valid = true;

                if($valid == true) {
                    return response()->json(['message' => 'Successfully updated' ], 200);
                } else {
                    return response()->json(['message' => 'Failed to update'], 204);
                }
            }
        }
    }


##Destroy 
public function destroy($id)
    {
        $data = Campaign::find($id);
        $old_image = public_path().'/campaigns/'.$data->image;
        unlink($old_image);
        Campaign::where('id', $id)->delete();
        return response()->json(['message' => 'Successfully delete.' ], 200);
}
