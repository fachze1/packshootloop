

<form method="post" action="feedback.php" class="feedbackform">
                    <td class="text-center">
                        <div class="container">
                            <div class="form-group">
                                <textarea class="form-control kommentarfelt" rows="10" cols="25" placeholder="Skriv problemet her..."
                                    name="orderrejectcomment"><?php echo $row['orderrejectcomment']; ?></textarea>
                            </div>
                        </div>
                    </td>
                    <td class="text-center">
                        <input type="hidden" name="style_1_line" value="<?php echo $row['style_1'];?>"></input>
                        <button type="button" class="btn btn-dark btnfeedback">Indsend feedback</button>
                    </td>
                </form>